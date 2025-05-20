<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BorrowRequests Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\InventoryItemsTable&\Cake\ORM\Association\BelongsTo $InventoryItems
 *
 * @method \App\Model\Entity\BorrowRequest newEmptyEntity()
 * @method \App\Model\Entity\BorrowRequest newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\BorrowRequest> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BorrowRequest get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\BorrowRequest findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\BorrowRequest patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\BorrowRequest> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\BorrowRequest|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\BorrowRequest saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\BorrowRequest>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BorrowRequest>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BorrowRequest>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BorrowRequest> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BorrowRequest>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BorrowRequest>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BorrowRequest>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BorrowRequest> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BorrowRequestsTable extends Table
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

        $this->setTable('borrow_requests');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('InventoryItems', [
            'foreignKey' => 'inventory_item_id',
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
            ->integer('user_id')
            ->notEmptyString('user_id');

            $validator
            ->integer('inventory_item_id')
            ->allowEmptyString('inventory_item_id'); // ✅ allow null if deleted
        

        $validator
            ->scalar('status')
            ->allowEmptyString('status');

        $validator
            ->date('request_date')
            ->allowEmptyDate('request_date');

        $validator
            ->date('return_date')
            ->allowEmptyDate('return_date');

        // Validate return_time (add if necessary)
        $validator
            ->time('return_time', 'Please provide a valid time for Return Time')
            ->allowEmptyString('return_time');  // Optional, if you want to allow empty time

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
{
    $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);
    $rules->add($rules->existsIn(['inventory_item_id'], 'InventoryItems'), ['errorField' => 'inventory_item_id']);

    // ✅ Only run this rule when adding a new borrow request
    $rules->add(function ($entity, $options) {
        // Only validate on NEW requests
        if ($entity->isNew()) {
            $inventoryTable = $this->getAssociation('InventoryItems')->getTarget();
            $item = $inventoryTable->get($entity->inventory_item_id);
            return $entity->quantity_requested <= $item->quantity;
        }
        return true;
    }, 'enoughQuantity', [
        'errorField' => 'quantity_requested',
        'message' => 'Requested quantity exceeds available inventory.'
    ]);

    return $rules;
}


}
