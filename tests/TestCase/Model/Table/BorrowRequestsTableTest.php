<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BorrowRequestsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BorrowRequestsTable Test Case
 */
class BorrowRequestsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\BorrowRequestsTable
     */
    protected $BorrowRequests;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.BorrowRequests',
        'app.Users',
        'app.InventoryItems',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('BorrowRequests') ? [] : ['className' => BorrowRequestsTable::class];
        $this->BorrowRequests = $this->getTableLocator()->get('BorrowRequests', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->BorrowRequests);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\BorrowRequestsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\BorrowRequestsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
