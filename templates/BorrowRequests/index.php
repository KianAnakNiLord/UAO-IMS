<?= $this->Html->css('borrow_requests_index') ?>

<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\BorrowRequest> $borrowRequests
 */
?>
<div class="borrowRequests index content">
    <?= $this->Html->link(__('New Borrow Request'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Borrow Requests') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('inventory_item_id') ?></th>
                    <th><?= __('Quantity') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('request_date') ?></th>
                    <th><?= $this->Paginator->sort('return_date') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($borrowRequests as $borrowRequest): ?>
                <tr>
                    <td><?= $this->Number->format($borrowRequest->id) ?></td>
                    <td>
                        <?= $borrowRequest->hasValue('user')
                            ? $this->Html->link($borrowRequest->user->name, ['controller' => 'Users', 'action' => 'view', $borrowRequest->user->id])
                            : '' ?>
                    </td>
                    <td>
                        <?= $borrowRequest->hasValue('inventory_item')
                            ? $this->Html->link($borrowRequest->inventory_item->name, ['controller' => 'InventoryItems', 'action' => 'view', $borrowRequest->inventory_item->id])
                            : '' ?>
                    </td>
                    <td><?= h($borrowRequest->quantity_requested) ?> pcs</td>
                    <td>
                        <?php
                            $status = $borrowRequest->status;
                            $color = match ($status) {
                                'approved' => 'green',
                                'pending' => 'orange',
                                'rejected' => 'red',
                                'returned' => 'blue',
                                'overdue' => 'darkred',
                                default => 'black'
                            };
                        ?>
                        <span style="color: <?= $color ?>;">
                            <?= ucfirst(h($status)) ?>
                        </span>
                        <?php if ($status === 'rejected' && $borrowRequest->rejection_reason): ?>
                            <br><small><strong>Reason:</strong> <?= h($borrowRequest->rejection_reason) ?></small>
                        <?php endif; ?>
                    </td>
                    <td><?= h($borrowRequest->request_date) ?></td>
                    <td><?= h($borrowRequest->return_date) ?></td>
                    <td><?= h($borrowRequest->created) ?></td>
                    <td><?= h($borrowRequest->modified) ?></td>
                    <td class="actions">
    <?= $this->Html->link(__('View'), ['action' => 'view', $borrowRequest->id], ['title' => 'View this request']) ?>
    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $borrowRequest->id], ['title' => 'Edit this request']) ?>
    <?= $this->Form->postLink(
        __('Delete'),
        ['action' => 'delete', $borrowRequest->id],
        [
            'confirm' => __('Are you sure you want to delete # {0}?', $borrowRequest->id),
            'class' => 'danger-btn',
            'title' => 'Delete this request'
        ]
    ) ?>
</td>

                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
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
