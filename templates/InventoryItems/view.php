<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InventoryItem $inventoryItem
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Inventory Item'), ['action' => 'edit', $inventoryItem->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Inventory Item'), ['action' => 'delete', $inventoryItem->id], ['confirm' => __('Are you sure you want to delete # {0}?', $inventoryItem->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Inventory Items'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Inventory Item'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="inventoryItems view content">
            <h3><?= h($inventoryItem->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($inventoryItem->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($inventoryItem->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Quantity') ?></th>
                    <td><?= $this->Number->format($inventoryItem->quantity) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($inventoryItem->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($inventoryItem->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($inventoryItem->description)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Borrow Requests') ?></h4>
                <?php if (!empty($inventoryItem->borrow_requests)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Inventory Item Id') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Request Date') ?></th>
                            <th><?= __('Return Date') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($inventoryItem->borrow_requests as $borrowRequest) : ?>
                        <tr>
                            <td><?= h($borrowRequest->id) ?></td>
                            <td><?= h($borrowRequest->user_id) ?></td>
                            <td><?= h($borrowRequest->inventory_item_id) ?></td>
                            <td><?= h($borrowRequest->status) ?></td>
                            <td><?= h($borrowRequest->request_date) ?></td>
                            <td><?= h($borrowRequest->return_date) ?></td>
                            <td><?= h($borrowRequest->created) ?></td>
                            <td><?= h($borrowRequest->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'BorrowRequests', 'action' => 'view', $borrowRequest->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'BorrowRequests', 'action' => 'edit', $borrowRequest->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'BorrowRequests', 'action' => 'delete', $borrowRequest->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $borrowRequest->id),
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>