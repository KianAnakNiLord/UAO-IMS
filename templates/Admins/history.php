<?= $this->Html->css('history') ?>

<h2 class="history-title">Borrow History</h2>

<div class="history-container">
    <!-- Search Form -->
    <div class="history-search">
        <?= $this->Form->create(null, ['type' => 'get']) ?>
            <div class="input">
                <?= $this->Form->label('name', 'Name') ?>
                <?= $this->Form->control('name', [
                    'type' => 'text',
                    'label' => false,
                    'placeholder' => 'Enter name to search'
                ]) ?>
            </div>
            <div class="input">
                <?= $this->Form->label('email', 'Email') ?>
                <?= $this->Form->control('email', [
                    'type' => 'text',
                    'label' => false,
                    'placeholder' => 'Enter email to search'
                ]) ?>
            </div>
            <?= $this->Form->button('Search') ?>
        <?= $this->Form->end() ?>
    </div>

    <!-- Display Table -->
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
                    <th><?= __('Overdue Duration') ?></th>
                    <th><?= __('Action') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($history)): ?>
                    <?php foreach ($history as $borrowRequest): ?>
                        <tr>
                            <td><?= h($borrowRequest->user->name) ?></td>
                            <td><?= h($borrowRequest->inventory_item->name) ?></td>
                            <td><?= h($borrowRequest->quantity_requested) ?> pcs</td>
                            <td>
                                <?php
                                    $status = $borrowRequest->status;
                                    $color = match ($status) {
                                        'approved' => 'green',
                                        'rejected' => 'red',
                                        'returned' => 'blue',
                                        default => 'black'
                                    };
                                ?>
                                <span style="color: <?= $color ?>;"><?= ucfirst(h($status)) ?></span>
                            </td>
                            <td><?= h($borrowRequest->request_date) ?></td>
                            <td><?= h($borrowRequest->return_date) ?></td>
                            <td><?= h($borrowRequest->return_time ?? 'N/A') ?></td>
                            <td><?= h($borrowRequest->overdue_duration ?? '-') ?></td>

                            <td>
                                <?= $this->Form->postLink(
                                    'Delete',
                                    ['action' => 'deleteHistory', $borrowRequest->id],
                                    [
                                        'confirm' => 'Are you sure you want to delete this record?',
                                        'class' => 'btn mark-overdue'
                                    ]
                                ) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="8">No history found for the provided criteria.</td></tr>
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
</div>
