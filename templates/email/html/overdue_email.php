<?php
/**
 * Variables:
 * @var \App\Model\Entity\User $user
 * @var \App\Model\Entity\InventoryItem $item
 * @var \App\Model\Entity\BorrowRequest $request
 */
?>
<div style="max-width:600px;margin:auto;border:1px solid #ccc;border-radius:8px;overflow:hidden;font-family:sans-serif;">
    <div style="background:#3A53A4;color:#fff;padding:16px;text-align:center;">
        <h2 style="margin:0;">Borrow Request Overdue</h2>
    </div>
    <div style="padding:20px;">
        <p>Hello <strong><?= h($user->name) ?></strong>,</p>

        <p>
            Your borrow request for <strong>"<?= h($item->name) ?>"</strong> is now <span style="color:#B99433;"><strong>OVERDUE</strong></span>.
        </p>

        <p>
            <strong>Due Date:</strong> <?= h($request->return_date->format('Y-m-d')) ?><br>
            <strong>Due Time:</strong> <?= h($request->return_time->format('H:i')) ?>
        </p>

        <p>Please return the item to the UAO office immediately to avoid further issues.</p>

        <p style="margin-top:30px;">Thank you,<br><strong>UAO Inventory Team</strong></p>
    </div>
</div>
