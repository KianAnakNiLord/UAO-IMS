<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Cake\Log\Log;
use Cake\ORM\Query\SelectQuery;

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
    ->requirePresence('password', 'create')
    ->notEmptyString('password')
    ->add('password', 'strength', [
        'rule' => function ($value, $context) {
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
    

}
