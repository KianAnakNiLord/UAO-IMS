<?= $this->Html->css('borrow_request_form') ?>
<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BorrowRequest $borrowRequest
 * @var \Cake\Collection\CollectionInterface|string[] $inventoryItems
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Borrow Requests'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="borrowRequests form content">
            <?= $this->Form->create($borrowRequest) ?>
            <fieldset>
                <legend><?= __('Submit Borrow Request') ?></legend>
                <?php
                    echo $this->Form->control('inventory_item_id', [
                        'options' => $inventoryItems,
                        'label' => 'Inventory Item',
                        'empty' => '-- Select Equipment --',
                    ]);

                    echo $this->Form->control('quantity_requested', [
                        'label' => 'Quantity',
                        'type' => 'number',
                        'min' => 1
                    ]);

                    echo $this->Form->control('request_date', [
                        'label' => 'Request Date',
                        'empty' => true
                    ]);

                    echo $this->Form->control('return_date', [
                        'label' => 'Return Date',
                        'empty' => true
                    ]);

                    echo $this->Form->control('return_time', [
                        'label' => 'Return Time',
                        'type' => 'time',
                        'empty' => true
                    ]);
                    
                    // ✅ NEW FIELD — Purpose
                    echo $this->Form->control('purpose', [
                        'label' => 'Purpose',
                        'type' => 'textarea',
                        'placeholder' => 'State the reason for borrowing...'
                    ]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
