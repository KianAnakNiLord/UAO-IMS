<?php
/**
 * @var \App\Model\Entity\User $user
 * @var \App\Model\Entity\InventoryItem $item
 * @var string $rejectionReason
 */
?>

<p style="font-size: 16px; color: #333;">
    Hello <strong><?= h($user->name) ?></strong>,
</p>

<p style="font-size: 16px; color: #333;">
    We regret to inform you that your borrow request for 
    <strong>"<?= h($item->name) ?>"</strong> has been <span style="color: #B99433; font-weight: bold;">REJECTED</span>.
</p>

<p style="font-size: 16px; color: #333;">
    <strong>Reason:</strong> <?= h($rejectionReason) ?>
</p>

<p style="font-size: 16px; color: #333;">
    If you have any questions or would like to clarify this decision, please contact the UAO office.
</p>

<p style="font-size: 16px; color: #333;">
    Thank you,<br>
    <span style="color: #3A53A4; font-weight: bold;">UAO Inventory Team</span>
</p>
