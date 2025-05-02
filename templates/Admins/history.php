<!-- templates/Admins/history.php -->
<?= $this->Html->css('history') ?>
<h2>Borrow History</h2>

<!-- Search Form -->
<div class="history-search">
    <?= $this->Form->create(null, ['type' => 'get']) ?>
    <label for="email">Search by Email:</label>
    <?= $this->Form->control('email', ['type' => 'text', 'placeholder' => 'Enter email to search']) ?>
    <?= $this->Form->button('Search') ?>
    <?= $this->Form->end() ?>
</div>

<!-- Display History Table -->
<div class="history-wrapper">
    <table class="history-table">
        <thead>
            <tr>
                <th><?= __('Name') ?></th>
                <th><?= __('Item') ?></th>
                <th><?= __('Quantity') ?></th>
                <th><?= __('Status') ?></th>
                <th><?= __('Request Date') ?></th>
                <th><?= __('Return Date') ?></th>
                <th><?= __('Return Time') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($history)): ?>
                <?php foreach ($history as $borrowRequest): ?>
                    <tr>
                        <td><?= h($borrowRequest->user->name) ?></td>
                        <td><?= h($borrowRequest->inventory_item->name) ?></td>
                        <td><?= h($borrowRequest->quantity_requested) ?> pcs</td>
                        
                        <!-- Status with color coding for approved/rejected -->
                        <td>
                            <?php
                                $status = $borrowRequest->status;
                                $color = match ($status) {
                                    'approved' => 'green',
                                    'rejected' => 'red',
                                    default => 'black'
                                };
                            ?>
                            <span style="color: <?= $color ?>;">
                                <?= ucfirst(h($status)) ?>
                            </span>
                        </td>
                        
                        <td><?= h($borrowRequest->request_date) ?></td>
                        <td><?= h($borrowRequest->return_date) ?></td>
                        <td><?= h($borrowRequest->return_time ?? 'N/A') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No history found for the provided email.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="history-pagination">
    <ul class="pagination">
        <?= $this->Paginator->first('<< ' . __('first')) ?>
        <?= $this->Paginator->prev('< ' . __('previous')) ?>
        <?= $this->Paginator->numbers() ?>
        <?= $this->Paginator->next(__('next') . ' >') ?>
        <?= $this->Paginator->last(__('last') . ' >>') ?>
    </ul>
    <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
</div>
