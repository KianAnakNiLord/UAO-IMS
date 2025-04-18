<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BorrowRequestsFixture
 */
class BorrowRequestsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'user_id' => 1,
                'inventory_item_id' => 1,
                'status' => 'Lorem ipsum dolor sit amet',
                'request_date' => '2025-04-18',
                'return_date' => '2025-04-18',
                'created' => '2025-04-18 10:26:49',
                'modified' => '2025-04-18 10:26:49',
            ],
        ];
        parent::init();
    }
}
