<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BorrowRequestsFixture
 */
class BorrowRequestsFixture extends TestFixture
{
    // ✅ Tell CakePHP to load these tables first
    public array $import = ['table' => 'borrow_requests'];

    public array $fields = [];

    // ✅ Specify dependencies for loading order
    public array $depends = ['UsersFixture', 'InventoryItemsFixture'];

    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'user_id' => 1,
                'inventory_item_id' => 1,
                'status' => 'pending',
                'quantity_requested' => 1,
                'request_date' => '2025-04-18',
                'return_date' => '2025-04-20',
                'return_time' => '14:00:00',
                'created' => '2025-04-18 10:26:49',
                'modified' => '2025-04-18 10:26:49',
            ],
        ];
        parent::init();
    }
}
