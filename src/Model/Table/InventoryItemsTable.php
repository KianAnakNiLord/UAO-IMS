<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * InventoryItems Model
 *
 * @property \App\Model\Table\BorrowRequestsTable&\Cake\ORM\Association\HasMany $BorrowRequests
 *
 * @method \App\Model\Entity\InventoryItem newEmptyEntity()
 * @method \App\Model\Entity\InventoryItem newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\InventoryItem> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\InventoryItem get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\InventoryItem findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\InventoryItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\InventoryItem> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\InventoryItem|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\InventoryItem saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\InventoryItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\InventoryItem>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\InventoryItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\InventoryItem> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\InventoryItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\InventoryItem>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\InventoryItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\InventoryItem> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class InventoryItemsTable extends Table
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

        $this->setTable('inventory_items');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('BorrowRequests', [
            'foreignKey' => 'inventory_item_id',
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
        ->scalar('name')
        ->maxLength('name', 100)
        ->requirePresence('name', 'create')
        ->notEmptyString('name');

    $validator
        ->scalar('description')
        ->allowEmptyString('description');

    $validator
        ->integer('quantity')
        ->requirePresence('quantity', 'create')
        ->notEmptyString('quantity');

    $validator
        ->scalar('category')
        ->requirePresence('category', 'create')
        ->notEmptyString('category');

    $validator
        ->scalar('item_condition')
        ->requirePresence('item_condition', 'create')
        ->notEmptyString('item_condition');

    $validator
        ->date('procurement_date')
        ->requirePresence('procurement_date', 'create')
        ->notEmptyDate('procurement_date');

    return $validator;
}
public function buildRules(RulesChecker $rules): RulesChecker
{
    $rules->addDelete(function ($entity, $options) {
        return $this->BorrowRequests->find()->where(['inventory_item_id' => $entity->id])->count() === 0;
    }, 'noBorrowRecords', [
        'errorField' => 'id',
        'message' => 'Cannot delete item in use.'
    ]);

    return $rules;
}

}
