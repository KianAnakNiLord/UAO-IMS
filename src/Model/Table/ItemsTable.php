<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Items Model
 *
 * Handles validation and data management for the 'items' table.
 */
class ItemsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('items');
        $this->setPrimaryKey('id');
        $this->setDisplayField('name');

        $this->addBehavior('Timestamp');

        // ✅ An Item can have many Borrowings
        $this->hasMany('Borrowings', [
            'foreignKey' => 'item_id',
            'dependent' => true,
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('name') // Ensure 'name' is a string
            ->maxLength('name', 255) // Limit the length to 255 characters
            ->requirePresence('name', 'create') // Required when creating a new item
            ->notEmptyString('name', 'Item name is required'); // Cannot be empty

        $validator
            ->scalar('description') // Ensure 'description' is a string
            ->allowEmptyString('description'); // Optional field

        $validator
            ->integer('quantity') // Ensure 'quantity' is an integer
            ->requirePresence('quantity', 'create') // Required when creating a new item
            ->notEmptyString('quantity', 'Quantity is required') // Cannot be empty
            ->greaterThanOrEqual('quantity', 0, 'Quantity must be a positive number'); // Prevent negative values

         $validator
            ->integer('quantity')
            ->greaterThanOrEqual('quantity', 0, 'Quantity cannot be negative.');

        return $validator;
    }
}
