<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Item $item
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Item'), ['action' => 'edit', $item->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Item'), ['action' => 'delete', $item->id], [
                'confirm' => __('Are you sure you want to delete "{0}"?', $item->name), 
                'class' => 'side-nav-item delete-btn'
            ]) ?>
            <?= $this->Html->link(__('Back to Inventory'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('Add New Item'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="items view content">
            <h3><?= h($item->name) ?></h3>
            <table>
                <!-- Item Details -->
                <tr>
                    <th><?= __('Item Name') ?></th>
                    <td><?= h($item->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Category') ?></th>
                    <td><?= h($item->category) ?></td>
                </tr>
                <tr>
                    <th><?= __('Item Type') ?></th>
                    <td><?= h($item->item_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Condition') ?></th>
                    <td><?= h($item->item_condition) ?></td>
                </tr>

                <!-- Inventory Information -->
                <tr>
                    <th><?= __('Item ID') ?></th>
                    <td><?= $this->Number->format($item->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Quantity') ?></th>
                    <td><?= $this->Number->format($item->quantity) ?></td>
                </tr>

                <!-- Timestamps -->
                <tr>
                    <th><?= __('Date Added') ?></th>
                    <td><?= h($item->created->format('m/d/Y, h:i A')) ?></td>
                </tr>
                <tr>
                    <th><?= __('Last Modified') ?></th>
                    <td><?= h($item->modified->format('m/d/Y, h:i A')) ?></td>
                </tr>
            </table>

            <!-- Description -->
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($item->description)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
