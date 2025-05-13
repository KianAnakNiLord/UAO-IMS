<?= $this->Html->css('borrow_request_form') ?>
<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BorrowRequest $borrowRequest
 * @var array $flatInventory
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
        <?= $this->Form->create($borrowRequest, ['type' => 'file']) ?>

            <fieldset>
                <legend><?= __('Submit Borrow Request') ?></legend>

                <!-- ✅ Category Filter -->
                <div class="form-group">
                    <label for="categoryFilter">Filter by Category</label>
                    <select id="categoryFilter" class="form-control">
                        <option value="">-- Choose Category --</option>
                        <option value="equipment">Equipment</option>
                        <option value="supply">Supply</option>
                        <option value="strength">Strength & Conditioning</option>
                    </select>
                </div>

                <!-- ✅ Flat Inventory Dropdown (with data-category) -->
                <div class="form-group">
                    <label for="inventorySelect">Inventory Item</label>
                    <select name="inventory_item_id" id="inventorySelect" class="form-control">
                        <option value="">-- Select Item --</option>
                        <?php foreach ($flatInventory as $item): ?>
                            <option value="<?= h($item->id) ?>" data-category="<?= h($item->category) ?>">
                                <?= h($item->name) ?> (Qty: <?= h($item->quantity) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <?= $this->Form->control('quantity_requested', [
                    'label' => 'Quantity',
                    'type' => 'number',
                    'min' => 1
                ]) ?>

                <?= $this->Form->control('request_date', [
                    'label' => 'Request Date',
                    'empty' => true
                ]) ?>

                <?= $this->Form->control('return_date', [
                    'label' => 'Return Date',
                    'empty' => true
                ]) ?>

                <?= $this->Form->control('return_time', [
                    'label' => 'Return Time',
                    'type' => 'time',
                    'empty' => true
                ]) ?>

                <?= $this->Form->control('purpose', [
                    'label' => 'Purpose',
                    'type' => 'textarea',
                    'placeholder' => 'State the reason for borrowing...'
                ]) ?>

                <?= $this->Form->control('id_image', [
                    'type' => 'file',
                    'label' => 'Upload Student/Employee ID',
                    'accept' => 'image/*'
                ]) ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<!-- ✅ Filter inventory items by category -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const categoryFilter = document.getElementById('categoryFilter');
    const inventorySelect = document.getElementById('inventorySelect');

    categoryFilter.addEventListener('change', function () {
        const selectedCategory = this.value;

        Array.from(inventorySelect.options).forEach(option => {
            if (!option.value) {
                option.style.display = 'block'; // always show placeholder
                return;
            }

            const itemCategory = option.getAttribute('data-category');
            option.style.display = (!selectedCategory || selectedCategory === itemCategory) ? 'block' : 'none';
        });

        inventorySelect.selectedIndex = 0;
    });
});
</script>
