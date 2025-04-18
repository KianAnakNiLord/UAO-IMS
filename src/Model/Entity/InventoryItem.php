<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * InventoryItem Entity
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $quantity
 * @property string|null $category
 * @property string|null $item_condition
 * @property \Cake\I18n\Date|null $procurement_date
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\BorrowRequest[] $borrow_requests
 */
class InventoryItem extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'name' => true,
        'description' => true,
        'quantity' => true,
        'category' => true,
        'item_condition' => true,
        'procurement_date' => true,
        'created' => true,
        'modified' => true,
        'borrow_requests' => true,
    ];
}
