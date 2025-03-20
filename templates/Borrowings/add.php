<h1>Borrow an Item</h1>

<?= $this->Form->create($borrowing) ?>
    <fieldset>
        <legend><?= __('Add Borrowing') ?></legend>
        <?= $this->Form->control('borrower_id', ['options' => $borrowers, 'label' => 'Select Borrower']) ?>
        <?= $this->Form->control('item_id', ['options' => $items, 'label' => 'Select Item']) ?>
        <?= $this->Form->control('borrowed_date', ['type' => 'date']) ?>
        <?= $this->Form->control('return_date', ['type' => 'date']) ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
<?= $this->Form->end() ?>

<p><?= $this->Html->link('Back to List', ['action' => 'index']) ?></p>
