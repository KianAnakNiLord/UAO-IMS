<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Event\EventInterface;
use ArrayObject;
use Cake\ORM\TableRegistry;

class SocialProfilesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('social_profiles');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
    }

    public function beforeSave(EventInterface $event, $entity, ArrayObject $options)
{
    if (!$entity->user_id && !empty($entity->email)) {
        // ✅ Fix: get Users table properly
        $usersTable = TableRegistry::getTableLocator()->get('Users');
        $user = $usersTable->find()->where(['email' => $entity->email])->first();
        if ($user) {
            $entity->user_id = $user->id;
        }
    }
}
}
