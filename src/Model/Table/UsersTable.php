<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Cake\Log\Log;
use Cake\ORM\Query\SelectQuery;
use Cake\Http\Exception\ForbiddenException;

/**
 * Users Model
 *
 * @property \App\Model\Table\BorrowRequestsTable&\Cake\ORM\Association\HasMany $BorrowRequests
 */
class UsersTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('users');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('BorrowRequests', [
            'foreignKey' => 'user_id',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('role')
            ->requirePresence('role', 'create')
            ->notEmptyString('role');

        $validator
            ->scalar('name')
            ->maxLength('name', 100)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

            $validator
    ->email('email')
    ->requirePresence('email', 'create')
    ->notEmptyString('email')
    ->add('validXavierEmail', 'custom', [
        'rule' => function ($value, $context) {
            return (bool)preg_match('/^\d{11}@my\.xu\.edu\.ph$/', (string)$value);
        },
        'message' => 'Please use a valid XU email (e.g., 20220000000@my.xu.edu.ph).'
    ]);

       $validator
    ->scalar('password')
    ->maxLength('password', 255)
    ->allowEmptyString('password', 'Password can be empty for social login.')
    ->add('password', 'strength', [
        'rule' => function ($value, $context) {
            // Only validate strength if password is provided
            if (empty($value)) {
                return true;
            }
            return (bool)preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/', (string)$value);
        },
        'message' => 'Password must be at least 8 characters and include a number, a lowercase and an uppercase letter.'
    ]);




        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
{
    $rules->add($rules->isUnique(
        ['email'],
        'This email is already registered.' // ✅ Custom message for uniqueness
    ));
    return $rules;
}


    /**
     * Used by AuthenticationService to fetch user for login
     */
    public function findAuth(\Cake\ORM\Query\SelectQuery $query, array $options)
{
    Log::write('debug', '✅ findAuth() triggered');
    return $query->select([
        'id', 'name', 'email', 'password', 'role', 'is_verified'
    ]);
}
    
    // 1. In your UsersTable.php
public function findOrCreateFromSocial($data)
{
    $socialProfilesTable = \Cake\ORM\TableRegistry::getTableLocator()->get('SocialProfiles');
    \Cake\Log\Log::write('error', '🔍 findOrCreateFromSocial() START for ' . json_encode($data));

    // ✅ Domain restriction
    if (!str_ends_with($data['email'], '@my.xu.edu.ph')) {
        throw new ForbiddenException('Only @my.xu.edu.ph emails are allowed.');
    }

    $provider = strtolower($data['provider'] ?? 'google');
    $identifier = (string)($data['identifier'] ?? '');

    if (!$identifier) {
        throw new \RuntimeException('Missing social profile identifier.');
    }

    $name = $data['name']
        ?? $data['full_name']
        ?? trim(($data['first_name'] ?? '') . ' ' . ($data['last_name'] ?? ''))
        ?: 'Unnamed';

    \Cake\Log\Log::write('error', "➡️ Looking for user: {$data['email']}");
    $user = $this->find()->where(['email' => $data['email']])->first();

    if (!$user) {
        \Cake\Log\Log::write('error', "👤 Creating new user for: {$data['email']}");
        $user = $this->newEntity([
            'email' => $data['email'],
            'name' => $name,
            'role' => 'borrower',
            'is_verified' => true,
        ]);
        $this->saveOrFail($user);
    } elseif ($user->name === 'Unnamed' && $name !== 'Unnamed') {
        \Cake\Log\Log::write('error', "✏️ Updating placeholder user name to: $name");
        $user->name = $name;
        $this->save($user);
    }

    \Cake\Log\Log::write('error', "🔍 Checking for existing social profile: $provider - $identifier");

    $existingProfile = $socialProfilesTable->find()
        ->where(['provider' => $provider, 'identifier' => $identifier])
        ->first();

    if ($existingProfile) {
        \Cake\Log\Log::write('error', "🔁 Updating existing profile for $identifier");

        $existingProfile = $socialProfilesTable->patchEntity($existingProfile, [
            'user_id' => $user->id,
            'email' => $data['email'],
            'full_name' => $name,
            'first_name' => $data['first_name'] ?? null,
            'last_name' => $data['last_name'] ?? null,
            'profile_url' => $data['profile_url'] ?? null,
            'image_url' => $data['image_url'] ?? null,
            'raw_data' => json_encode($data),
        ]);
        $socialProfilesTable->save($existingProfile);
        return $user;
    }

    \Cake\Log\Log::write('error', "✅ Creating NEW social profile for $identifier");

    // 🔒 Final duplicate check before insert
    $alreadyExists = $socialProfilesTable->exists([
        'provider' => $provider,
        'identifier' => $identifier
    ]);

    if ($alreadyExists) {
        \Cake\Log\Log::write('debug', "🛑 Profile already exists at final check. Skipping insert.");
        return $user;
    }

    $socialProfile = $socialProfilesTable->newEntity([
        'user_id' => $user->id,
        'provider' => $provider,
        'identifier' => $identifier,
        'email' => $data['email'],
        'full_name' => $name,
        'first_name' => $data['first_name'] ?? null,
        'last_name' => $data['last_name'] ?? null,
        'profile_url' => $data['profile_url'] ?? null,
        'image_url' => $data['image_url'] ?? null,
        'raw_data' => json_encode($data),
    ]);

    if (!$socialProfilesTable->save($socialProfile)) {
        \Cake\Log\Log::write('warning', "❗ Save failed. Retrying lookup in case it was inserted in parallel...");

        $fallback = $socialProfilesTable->find()
            ->where(['provider' => $provider, 'identifier' => $identifier])
            ->first();

        if ($fallback) {
            \Cake\Log\Log::write('debug', "✅ Found profile after failed save. Returning user.");
            return $user;
        }

        throw new \RuntimeException("❌ Could not save or find social profile for: $identifier");
    }

    return $user;
}

}
