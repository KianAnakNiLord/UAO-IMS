<?= $this->Html->css('decision_form') ?>

<div class="reject-form-wrapper">
    <div class="reject-form-card">
        <h2 class="reject-title">Reject Borrow Request</h2>

        <?= $this->Form->create($request, ['url' => ['action' => 'rejectRequest', $request->id]]) ?>

        <div class="info-row"><strong>Borrower:</strong> <?= h($request->user->name ?? 'N/A') ?></div>
        <div class="info-row"><strong>Item:</strong> <?= h($request->inventory_item->name ?? 'N/A') ?></div>
        <div class="info-row"><strong>Quantity:</strong> <?= h($request->quantity_requested) ?></div>

        <div class="form-group">
    <?= $this->Form->label('rejection_reason', 'Reason for Rejection') ?>
    <?= $this->Form->textarea('rejection_reason', [
        'id' => 'rejectionReason',
        'maxlength' => 75,
        'required' => true,
        'placeholder' => 'Explain why this request is being rejected',
        'style' => 'resize: none;',
        'class' => 'form-control'
    ]) ?>
    <small id="rejectionCharCount" style="font-size: 13px; color: #666; display: block; margin-top: 6px;">0 / 75</small>
</div>


        <div class="form-buttons">
            <?= $this->Form->button('Submit Rejection', ['class' => 'reject-btn']) ?>
            <?= $this->Html->link('Cancel', ['action' => 'borrowRequests'], ['class' => 'cancel-btn']) ?>
        </div>

        <?= $this->Form->end() ?>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const approvalInput = document.getElementById('approvalNote');
    const approvalCounter = document.getElementById('approvalCharCount');

    if (approvalInput) {
        approvalInput.addEventListener('input', () => {
            const length = approvalInput.value.length;
            approvalCounter.textContent = `${length} / 75`;
            approvalCounter.style.color = length > 75 ? 'red' : '#666';
        });
    }
    const rejectionInput = document.getElementById('rejectionReason');
    const rejectionCounter = document.getElementById('rejectionCharCount');

    if (rejectionInput) {
        rejectionInput.addEventListener('input', () => {
            const length = rejectionInput.value.length;
            rejectionCounter.textContent = `${length} / 75`;
            rejectionCounter.style.color = length > 75 ? 'red' : '#666';
        });
    }
});
</script>
