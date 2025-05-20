<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BorrowRequest Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $inventory_item_id
 * @property string|null $status
 * @property \Cake\I18n\Date|null $request_date
 * @property \Cake\I18n\Date|null $return_date
 * @property string|null $purpose
 * @property int|null $quantity_requested
 * @property string|null $rejection_reason
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\InventoryItem $inventory_item
 */
class BorrowRequest extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'user_id' => true,
        'inventory_item_id' => true,
        'status' => true,
        'request_date' => true,
        'return_date' => true,
        'quantity_requested' => true, // ✅ make sure this is included
        'purpose' => true,            // ✅ new field
        'rejection_reason' => true,   // ✅ for admin-side rejection
        'created' => true,
        'modified' => true,
        'user' => true,
        'inventory_item' => true,
        'return_time' => true, // Make sure return_time is included here
        'id_image' => true,
            'returned_good' => true,
    'returned_damaged' => true,
    ];
}
