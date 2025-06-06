<?= $this->Html->css('decision_form') ?>

<div class="reject-form-wrapper">
    <div id="errorPopup" style="
    display: none;
    position: fixed;
    top: 30px;
    left: 50%;
    transform: translateX(-50%);
    background: white;
    color: red;
    border: 2px solid red;
    padding: 16px 24px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    font-weight: bold;
    text-align: center;
    max-width: 90%;
    width: fit-content;
    z-index: 9999;
"></div>


    <div class="reject-form-card">
        <h2 class="reject-title">Approve Borrow Request</h2>

        <?= $this->Form->create($request, ['url' => ['action' => 'approveRequest', $request->id]]) ?>

        <div class="info-row"><strong>Borrower:</strong> <?= h($request->user->name ?? 'N/A') ?></div>
        <div class="info-row"><strong>Item:</strong> <?= h($request->inventory_item->name ?? 'N/A') ?></div>
        <div class="info-row"><strong>Quantity:</strong> <?= h($request->quantity_requested) ?></div>

        <div class="form-group">
            <?= $this->Form->label('approval_note', 'Approval Note (Optional)') ?>
            <?= $this->Form->textarea('approval_note', [
                'id' => 'approvalNote',
                'maxlength' => 75,
                'placeholder' => 'You can leave a note for the borrower...',
                'style' => 'resize: none;',
                'class' => 'form-control'
            ]) ?>
            <small id="approvalCharCount" style="font-size: 13px; color: #666; display: block; margin-top: 6px;">0 / 75</small>
        </div>

        <div class="form-buttons">
            <?= $this->Form->button('Confirm Approval', ['class' => 'reject-btn']) ?>
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
<?php if (!empty($flashError)): ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const flashMessage = <?= json_encode($flashError) ?>;

    const errorPopup = document.getElementById('errorPopup');

    if (errorPopup && flashMessage) {
        errorPopup.textContent = flashMessage;
        errorPopup.style.display = 'block';

        setTimeout(() => {
            errorPopup.style.display = 'none';
        }, 3000);
    }
});
</script>
<?php endif; ?>
