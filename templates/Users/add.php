<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BorrowRequest $borrowRequest
 * @var \Cake\Collection\CollectionInterface|string[] $inventoryItems
 */
?>
<?= $this->Html->css('borrow_request_form') ?>
<div class="borrowRequests form content">
    <h1>Borrow Equipment</h1>

    <?= $this->Form->create($borrowRequest) ?>
    <fieldset>
        <legend>Submit Borrow Request</legend>

        <?php
            echo $this->Form->control('inventory_item_id', [
                'label' => 'Select Item',
                'options' => $inventoryItems,
                'empty' => '-- Choose Equipment --',
                'required' => true
            ]);

            echo $this->Form->control('request_date', [
                'label' => 'Borrow Date',
                'type' => 'date',
                'required' => true
            ]);

            echo $this->Form->control('return_date', [
                'label' => 'Expected Return Date',
                'type' => 'date',
                'required' => true
            ]);

            // Add Return Time field here
            echo $this->Form->control('return_time', [
                'label' => 'Return Time',
                'type' => 'time',
                'empty' => true
            ]);
        ?>
    </fieldset>

    <?= $this->Form->button(__('Submit Request')) ?>
    <?= $this->Form->end() ?>
</div>
