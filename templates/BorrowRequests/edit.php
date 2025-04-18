<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BorrowRequest $borrowRequest
 * @var string[]|\Cake\Collection\CollectionInterface $users
 * @var string[]|\Cake\Collection\CollectionInterface $inventoryItems
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $borrowRequest->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $borrowRequest->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Borrow Requests'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="borrowRequests form content">
            <?= $this->Form->create($borrowRequest) ?>
            <fieldset>
                <legend><?= __('Edit Borrow Request') ?></legend>
                <?php
                    echo $this->Form->control('user_id', ['options' => $users]);
                    echo $this->Form->control('inventory_item_id', ['options' => $inventoryItems]);
                    echo $this->Form->control('status');
                    echo $this->Form->control('request_date', ['empty' => true]);
                    echo $this->Form->control('return_date', ['empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
