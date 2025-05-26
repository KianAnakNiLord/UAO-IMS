<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BorrowRequestsTable;
use Cake\TestSuite\TestCase;

/**
 * BorrowRequestsTable Test Case
 */
class BorrowRequestsTableTest extends TestCase
{
    /**
     * @var \App\Model\Table\BorrowRequestsTable
     */
    protected $BorrowRequests;

    /**
     * @var list<string>
     */
    protected array $fixtures = [
        'app.BorrowRequests',
        'app.Users',
        'app.InventoryItems',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('BorrowRequests') ? [] : ['className' => BorrowRequestsTable::class];
        $this->BorrowRequests = $this->getTableLocator()->get('BorrowRequests', $config);
    }

    protected function tearDown(): void
    {
        unset($this->BorrowRequests);
        parent::tearDown();
    }

    /**
     * Test saving a valid borrow request
     */
    public function testSaveValidBorrowRequest(): void
    {
        $data = [
            'user_id' => 1,
            'inventory_item_id' => 1,
            'status' => 'pending',
            'quantity_requested' => 1,
            'return_date' => '2025-07-01',
            'return_time' => '15:00:00'
        ];

        $entity = $this->BorrowRequests->newEntity($data);
        $this->assertEmpty($entity->getErrors(), 'Validation errors occurred.');

        $saved = $this->BorrowRequests->save($entity);
        $this->assertNotFalse($saved, 'Failed to save valid borrow request.');
    }
}
