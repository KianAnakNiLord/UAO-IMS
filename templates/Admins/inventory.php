<?= $this->Html->css('inventory') ?>

<h2>Inventory Management</h2>

<?= $this->Html->link('➕ Add New Item', ['action' => 'addInventory'], ['class' => 'btn primary-btn']) ?>
<?= $this->Html->link('⬇ Export as PDF', ['action' => 'exportInventoryPdf'], ['class' => 'btn primary-btn']) ?>

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
            <th>Available</th>
            <th>Borrowed</th>
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
            <td><?= h(ucwords($item->item_condition)) ?></td>
            <td><?= h($item->quantity) ?></td>
            <td><?= h($item->total_borrowed ?? 0) ?></td>
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
