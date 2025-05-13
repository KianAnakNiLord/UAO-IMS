<?= $this->Html->css('inventory') ?>

<div class="inventory-form-wrapper">
    <div class="inventory-form-card">
        <h2 class="inventory-form-title">Add Inventory Item</h2>

        <?= $this->Form->create($item) ?>

        <?= $this->Form->control('name', [
            'label' => 'Item Name',
            'placeholder' => 'e.g. Basketball Ring'
        ]) ?>

        <?= $this->Form->control('procurement_date', [
            'label' => 'Procurement Date',
            'type' => 'date'
        ]) ?>

        <?= $this->Form->control('description', [
            'label' => 'Description',
            'placeholder' => 'Optional notes'
        ]) ?>

        <?= $this->Form->control('quantity', [
            'label' => 'Quantity',
            'type' => 'number',
            'min' => 1,
            'placeholder' => 'e.g. 5'
        ]) ?>

        <?= $this->Form->control('category', [
            'label' => 'Category',
            'options' => [
                'equipment' => 'Equipment',
                'supply' => 'Supply',
                'strength' => 'Strength & Conditioning',
            ],
            'empty' => 'Choose category'
        ]) ?>

        <?= $this->Form->control('item_condition', [
            'label' => 'Condition',
            'options' => [
                'new' => 'New',
                'used' => 'Used',
                'damaged' => 'Damaged'
            ],
            'empty' => 'Choose condition'
        ]) ?>

        <?= $this->Form->button('Add Item', ['class' => 'inventory-btn']) ?>
        <?= $this->Form->end() ?>

        <p class="form-footer" style="margin-top: 15px; text-align: center;">
            <a href="<?= $this->Url->build(['action' => 'inventory']) ?>" style="color: #3A53A4; text-decoration: underline;">
                Cancel and go back to inventory
            </a>
        </p>
    </div>
</div>
