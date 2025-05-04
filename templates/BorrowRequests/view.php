<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BorrowRequest $borrowRequest
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Borrow Request'), ['action' => 'edit', $borrowRequest->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Borrow Request'), ['action' => 'delete', $borrowRequest->id], ['confirm' => __('Are you sure you want to delete # {0}?', $borrowRequest->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Borrow Requests'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Borrow Request'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="borrowRequests view content">
            <h3><?= h($borrowRequest->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $borrowRequest->hasValue('user') ? $this->Html->link($borrowRequest->user->name, ['controller' => 'Users', 'action' => 'view', $borrowRequest->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Inventory Item') ?></th>
                    <td><?= $borrowRequest->hasValue('inventory_item') ? $this->Html->link($borrowRequest->inventory_item->name, ['controller' => 'InventoryItems', 'action' => 'view', $borrowRequest->inventory_item->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($borrowRequest->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($borrowRequest->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Request Date') ?></th>
                    <td><?= h($borrowRequest->request_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Return Date') ?></th>
                    <td><?= h($borrowRequest->return_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($borrowRequest->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($borrowRequest->modified) ?></td>
                </tr>
            </table>

            <?php if (!empty($borrowRequest->id_image)): ?>
                <div style="margin-top: 20px;">
                    <strong>ID Image:</strong><br>
                    <img src="/uploads/<?= h($borrowRequest->id_image) ?>" width="150" alt="Submitted ID">
                </div>
            <?php else: ?>
                <p><em>No ID image submitted.</em></p>
            <?php endif; ?>
        </div>
    </div>
</div>
