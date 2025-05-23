<?= $this->Html->css('view_reason') ?>

<div class="view-reason-wrapper">
    <div class="view-reason-card">
        <h2 class="view-reason-title">Return Remarks</h2>

        <div class="info-row"><strong>Borrower:</strong> <?= h($request->user->name ?? 'N/A') ?></div>
        <div class="info-row"><strong>Item:</strong> <?= h($request->inventory_item->name ?? 'N/A') ?></div>
        <div class="info-row"><strong>Returned:</strong> <?= h($request->returned_good) ?> good, <?= h($request->returned_damaged) ?> damaged</div>

        <div class="info-row">
            <strong>Remarks:</strong><br>
            <textarea readonly><?= h($request->return_remark ?? '—') ?></textarea>
        </div>

        <div class="form-buttons">
            <?= $this->Html->link('Back', ['action' => 'index'], ['class' => 'cancel-btn']) ?>
        </div>
    </div>
</div>
