<div class="card-container">
    <h1 class="section-title">Borrow an Item</h1>
    <?= $this->Form->create($borrowing, ['type' => 'file', 'class' => 'styled-form']) ?>
        <fieldset>
            <legend><?= __('Add Borrowing') ?></legend>
            <div class="form-group">
                <?= $this->Form->control('item_id', ['options' => $items, 'label' => 'Select Item', 'class' => 'form-control']) ?>
            </div>
            <div class="form-group">
                <?= $this->Form->control('quantity', ['type' => 'number', 'label' => 'Quantity to Borrow', 'min' => 1, 'class' => 'form-control']) ?>
            </div>
            <div class="form-group">
                <?= $this->Form->control('borrowed_date', ['type' => 'date', 'label' => 'Borrowed Date', 'class' => 'form-control']) ?>
            </div>
            <div class="form-group">
                <?= $this->Form->control('return_date', ['type' => 'date', 'label' => 'Return Date', 'class' => 'form-control']) ?>
            </div>
            <div class="form-group">
                <?= $this->Form->control('attachment', ['type' => 'file', 'label' => 'Attach File', 'class' => 'form-control']) ?>
            </div>
        </fieldset>
        <div class="button-group">
            <?= $this->Form->button(__('Submit'), ['class' => 'button blue']) ?>
        </div>
    <?= $this->Form->end() ?>
</div>