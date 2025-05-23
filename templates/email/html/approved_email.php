<!-- File: templates/email/html/approved_email.php -->
<?php
/**
 * @var \App\Model\Entity\User $user
 * @var \App\Model\Entity\InventoryItem $item
 * @var \App\Model\Entity\BorrowRequest $request
 * @var string|null $note
 */
?>

<p>Hello <?= h($user->name) ?>,</p>

<p>
    Your borrow request for <strong>"<?= h($item->name) ?>"</strong> has been 
    <span style="color: green; font-weight: bold;">APPROVED</span>.
</p>

<p>
    Please return the item by 
    <strong><?= h($request->return_date->format('n/j/y')) ?> at <?= h($request->return_time->format('g:i A')) ?></strong>.
</p>

<?php if (!empty($note)): ?>
    <p style="margin-top: 10px; padding: 10px; background-color: #fff8dc; border-left: 4px solid #B99433;">
        <strong>Admin Note:</strong> <?= h($note) ?>
    </p>
<?php endif; ?>

<p>
    Thank you,<br>
    <strong style="color: #3A53A4;">UAO Inventory Team</strong>
</p>
