<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Borrowings Model
 *
 * Handles validation and data management for the 'borrowings' table.
 */
class BorrowingsTable extends Table
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
    
        $this->setTable('borrowings');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
    
        // ✅ Borrowings belongs to Borrowers
        $this->belongsTo('Borrowers', [
            'foreignKey' => 'borrower_id',
            'joinType' => 'INNER',
        ]);
    
        // ✅ Borrowings belongs to Items
        $this->belongsTo('Items', [
            'foreignKey' => 'item_id',
            'joinType' => 'INNER',
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
            ->integer('borrower_id')
            ->requirePresence('borrower_id', 'create')
            ->notEmptyString('borrower_id', 'Borrower ID is required');
    
        $validator
            ->integer('item_id')
            ->requirePresence('item_id', 'create')
            ->notEmptyString('item_id', 'Item ID is required');
    
        // ✅ Fix field name to match the database column
        $validator
            ->date('borrowed_date')
            ->requirePresence('borrowed_date', 'create')
            ->notEmptyDate('borrowed_date', 'Borrowed date is required');
    
        $validator
            ->date('return_date') // assuming this is your due date
            ->allowEmptyDate('return_date');
    
        return $validator;
    }
}
