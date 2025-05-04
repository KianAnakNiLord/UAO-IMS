<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Borrowing Entity
 *
 * @property int $id
 * @property int $borrower_id
 * @property int $item_id
 * @property \Cake\I18n\DateTime|null $borrowed_date
 * @property \Cake\I18n\DateTime|null $due_date
 * @property \Cake\I18n\DateTime|null $returned_date
 * @property string|null $status
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 */
class Borrowing extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */

     protected array $_accessible = [
        'borrower_id' => true,
        'item_id' => true,
        'quantity' => true,
        'borrowed_date' => true,
        'return_date' => true,
        'status' => true,
        'attachment' => true,
        'created' => true,
        'modified' => true,
    ];
}
