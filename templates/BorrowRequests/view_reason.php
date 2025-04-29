<?= $this->Html->css('view_reason') ?>

<div class="view-reason-wrapper">
    <div class="view-reason-card">
        <h2 class="view-reason-title">Rejection Reason</h2>

        <div class="info-row"><strong>Borrower:</strong> <?= h($request->user->name ?? 'N/A') ?></div>
        <div class="info-row"><strong>Item:</strong> <?= h($request->inventory_item->name ?? 'N/A') ?></div>
        <div class="info-row"><strong>Quantity:</strong> <?= h($request->quantity_requested) ?></div>
        <div class="info-row"><strong>Return Time:</strong> <?= h($request->return_time) ?></div>

        <div class="form-group">
            <?= $this->Form->control('rejection_reason', [
                'type' => 'textarea',
                'label' => 'Reason for Rejection',
                'readonly' => true,
                'value' => $request->rejection_reason,
                'placeholder' => 'No reason provided.',
            ]) ?>
        </div>

        <div class="form-buttons">
            <?= $this->Html->link('Back to Requests', ['action' => 'index'], ['class' => 'cancel-btn']) ?>
        </div>
    </div>
</div>
