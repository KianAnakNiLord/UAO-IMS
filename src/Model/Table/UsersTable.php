<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator; // Import the correct Validator class
use Cake\Event\EventInterface;
use ArrayObject;

class UsersTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        // Set the table name
        $this->setTable('users');

        // Set the display field (optional)
        $this->setDisplayField('name');

        // Set the primary key
        $this->setPrimaryKey('id');

        // Add behaviors if needed (e.g., Timestamp)
        $this->addBehavior('Timestamp');
    }

    public function beforeSave(EventInterface $event, $entity, ArrayObject $options)
    {
        if ($entity->isNew() && !empty($entity->password)) {
            $entity->password = password_hash($entity->password, PASSWORD_DEFAULT);
        }
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->notEmptyString('username', 'A username is required')
            ->notEmptyString('password', 'A password is required')
            ->notEmptyString('email', 'An email address is required')
            ->add('email', 'validFormat', [
                'rule' => 'email',
                'message' => 'Please enter a valid email address',
            ]);

        return $validator;
    }
}