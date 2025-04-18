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
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $inventoryItem->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $inventoryItem->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Inventory Items'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="inventoryItems form content">
            <?= $this->Form->create($inventoryItem) ?>
            <fieldset>
                <legend><?= __('Edit Inventory Item') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('description');
                    echo $this->Form->control('quantity');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
