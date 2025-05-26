<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InventoryItemsTable;
use Cake\TestSuite\TestCase;

/**
 * InventoryItemsTable Test Case
 */
class InventoryItemsTableTest extends TestCase
{
    /**
     * @var \App\Model\Table\InventoryItemsTable
     */
    protected $InventoryItems;

    /**
     * @var list<string>
     */
    protected array $fixtures = [
    'app.Users',
    'app.InventoryItems',
    // 'app.BorrowRequests', ← comment or remove this!
];

    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('InventoryItems') ? [] : ['className' => InventoryItemsTable::class];
        $this->InventoryItems = $this->getTableLocator()->get('InventoryItems', $config);
    }

    protected function tearDown(): void
    {
        unset($this->InventoryItems);
        parent::tearDown();
    }

    /**
     * Test saving a valid inventory item
     */
    public function testSaveValidInventoryItem(): void
    {
        $data = [
            'name' => 'Official Basketball',
            'category' => 'equipment',
            'item_condition' => 'new',
            'quantity' => 5,
            'procurement_date' => '2024-01-15',
            'description' => 'Molten brand, leather',
            'location' => 'UAO-Storage'
        ];

        $entity = $this->InventoryItems->newEntity($data);
        $this->assertEmpty($entity->getErrors(), 'Validation errors found on valid inventory item.');

        $saved = $this->InventoryItems->save($entity);
        $this->assertNotFalse($saved, 'Valid inventory item could not be saved.');
    }
}
