<?= $this->Html->css('reject_form') ?>

<div class="reject-form-wrapper">
    <div class="reject-form-card">
        <h2 class="reject-title">Reject Borrow Request</h2>

        <?= $this->Form->create($request, ['url' => ['action' => 'rejectRequest', $request->id]]) ?>

        <div class="info-row"><strong>Borrower:</strong> <?= h($request->user->name ?? 'N/A') ?></div>
        <div class="info-row"><strong>Item:</strong> <?= h($request->inventory_item->name ?? 'N/A') ?></div>
        <div class="info-row"><strong>Quantity:</strong> <?= h($request->quantity_requested) ?></div>

        <div class="form-group">
            <?= $this->Form->control('rejection_reason', [
                'type' => 'textarea',
                'label' => 'Reason for Rejection',
                'required' => true,
                'placeholder' => 'Explain why this request is being rejected'
            ]) ?>
        </div>

        <div class="form-buttons">
            <?= $this->Form->button('Submit Rejection', ['class' => 'reject-btn']) ?>
            <?= $this->Html->link('Cancel', ['action' => 'borrowRequests'], ['class' => 'cancel-btn']) ?>
        </div>

        <?= $this->Form->end() ?>
    </div>
</div>
