<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * InventoryItemsFixture
 */
class InventoryItemsFixture extends TestFixture
{
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'name' => 'Test Ball',
                'category' => 'equipment',
                'item_condition' => 'new',
                'quantity' => 10,
                'procurement_date' => '2024-01-01',
                'description' => 'Test description',
                'location' => 'UAO Office',
                'created' => '2025-01-01 00:00:00',
                'modified' => '2025-01-01 00:00:00'
            ],
        ];
        parent::init();
    }
}
