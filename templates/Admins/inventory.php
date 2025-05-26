<?= $this->Html->css('inventory') ?>

<div class="inventory-header">
    <h2>Inventory Management</h2>
    <div class="button-group">
        <?= $this->Html->link('➕ Add New Item', ['action' => 'addInventory'], ['class' => 'btn primary-btn']) ?>
        <?= $this->Html->link('⬇ Export as PDF', ['action' => 'exportInventoryPdf'], ['class' => 'btn export-btn']) ?>
    </div>
</div>

<div class="inventory-filters">
    <?= $this->Form->create(null, ['type' => 'get']) ?>
    <fieldset>
        <legend>Filter Inventory</legend>

        <?= $this->Form->control('category', [
            'label' => 'Category',
            'options' => [
                '' => 'All',
                'Equipment' => 'Equipment',
                'Supply' => 'Supply',
                'Strength & Conditioning' => 'Strength & Conditioning',
            ],
            'default' => $this->request->getQuery('category')
        ]) ?>

        <?= $this->Form->control('condition', [
            'label' => 'Condition',
            'options' => [
                '' => 'All',
                'New' => 'New',
                'Used' => 'Used',
                'Damaged' => 'Damaged'
            ],
            'default' => $this->request->getQuery('condition')
        ]) ?>

        <?= $this->Form->control('location', [
            'label' => 'Location',
            'options' => [
                '' => 'All',
                'UA Office' => 'UA Office',
                'Covered Court' => 'Covered Court',
                'Covered Court-Green Rm' => 'Covered Court-Green Rm',
                'UAO-Storage' => 'UAO-Storage',
                'Gym' => 'Gym'
            ],
            'default' => $this->request->getQuery('location')
        ]) ?>

        <?= $this->Form->submit('Apply Filters') ?>
    </fieldset>
    <?= $this->Form->end() ?>
</div>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Category</th>
            <th>Condition</th>
            <th>Quantity</th>
            <th>Location</th>
            <th>Procurement Date</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($inventoryItems as $item): ?>
        <tr>
            <td><?= h($item->name) ?></td>
            <td><?= h(ucwords(str_replace('_', ' ', $item->category))) ?></td>
            <td>
                <?php
                    $condition = strtolower($item->item_condition);
                    $conditionClass = match ($condition) {
                        'new' => 'condition-new',
                        'used' => 'condition-used',
                        'damaged' => 'condition-damaged',
                        default => ''
                    };
                ?>
                <span class="condition-tag <?= $conditionClass ?>">
                    <?= ucfirst(h($condition)) ?>
                </span>
            </td>
            <td>
                <?= h($item->quantity) ?>
                <?php if (strtolower($item->item_condition) !== 'damaged'): ?>
                    <br>
                    <small style="color: gray;">Borrowed: <?= h($item->total_borrowed ?? 0) ?></small>
                    <br>
                    <small style="color: #cc0000;">Returned Damaged: <?= h($item->total_damaged ?? 0) ?></small>
                <?php endif; ?>
            </td>
            <td><?= h($item->location) ?></td>
            <td><?= h($item->procurement_date) ?></td>
            <td><?= h($item->description) ?></td>
            <td>
                <?= $this->Html->link('Edit', ['action' => 'editInventory', $item->id], ['class' => 'btn small-btn']) ?>
                <?= $this->Form->postLink('Delete', ['action' => 'deleteInventory', $item->id], [
                    'confirm' => 'Are you sure?',
                    'class' => 'btn danger-btn small-btn'
                ]) ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
