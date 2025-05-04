<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class BorrowingsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('borrowings');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        // Borrowings belongs to Users (logged-in user as borrower)
        $this->belongsTo('Users', [
            'foreignKey' => 'borrower_id', // Ensure this matches the column in the `borrowings` table
            'joinType' => 'INNER',
        ]);

        // Borrowings belongs to Items
        $this->belongsTo('Items', [
            'foreignKey' => 'item_id',
            'joinType' => 'INNER',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('borrower_id')
            ->requirePresence('borrower_id', 'create')
            ->notEmptyString('borrower_id', 'Borrower ID is required.');

        $validator
            ->integer('item_id')
            ->requirePresence('item_id', 'create')
            ->notEmptyString('item_id', 'Item ID is required.');

        $validator
            ->integer('quantity')
            ->requirePresence('quantity', 'create')
            ->notEmptyString('quantity', 'Quantity is required.')
            ->greaterThan('quantity', 0, 'Quantity must be greater than zero.');

        $validator
            ->date('borrowed_date')
            ->requirePresence('borrowed_date', 'create')
            ->notEmptyDate('borrowed_date', 'Borrowed date is required.');

        $validator
            ->date('return_date')
            ->requirePresence('return_date', 'create')
            ->notEmptyDate('return_date', 'Return date is required.');

        return $validator;
    }
    }
