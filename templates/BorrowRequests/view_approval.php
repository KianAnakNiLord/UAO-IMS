<?= $this->Html->css('view_reason') ?>

<div class="view-reason-wrapper">
    <div class="view-reason-card">
        <h2 class="view-reason-title">Approval Note</h2>

        <div class="info-row"><strong>Borrower:</strong> <?= h($request->user->name ?? 'N/A') ?></div>
        <div class="info-row"><strong>Item:</strong> <?= h($request->inventory_item->name ?? 'N/A') ?></div>
        <div class="info-row"><strong>Quantity:</strong> <?= h($request->quantity_requested) ?></div>
        <div class="info-row"><strong>Return Time:</strong> <?= h($request->return_time) ?></div>

        <div class="form-group">
            <?= $this->Form->control('approval_note', [
                'type' => 'textarea',
                'label' => 'Message from Admin',
                'readonly' => true,
                'value' => $request->approval_note,
                'placeholder' => 'No message provided.',
            ]) ?>
        </div>

        <div class="form-buttons">
            <?= $this->Html->link('Back to Requests', ['action' => 'index'], ['class' => 'cancel-btn']) ?>
        </div>
    </div>
</div>
