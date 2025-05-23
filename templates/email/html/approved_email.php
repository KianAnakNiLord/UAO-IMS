<!-- File: templates/email/html/approved_email.php -->
<div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; border: 1px solid #ccc; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">

    <div style="background-color: #3A53A4; color: white; padding: 20px;">
        <h2 style="margin: 0; font-size: 20px;">Borrow Request Approved</h2>
    </div>

    <div style="padding: 20px; background-color: #fefefe; color: #333;">
        <p>Hello <?= h($user->name) ?>,</p>

        <p>Your borrow request for <strong>"<?= h($item->name) ?>"</strong> has been <span style="color: green; font-weight: bold;">APPROVED</span>.</p>

        <p>Please return the item by <strong><?= h($request->return_date) ?> at <?= h($request->return_time) ?></strong>.</p>

        <?php if (!empty($note)): ?>
            <p style="background-color: #FFF8E1; border-left: 4px solid #B99433; padding: 10px; margin: 20px 0; font-style: italic;">
                Admin Note: "<?= h($note) ?>"
            </p>
        <?php endif; ?>

        <p>Thank you,<br>
        <strong style="color: #3A53A4">UAO Inventory Team</strong></p>
    </div>
</div>
