<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Item> $items
 */
?>

<div class="inventory-container">
    <!-- PAGE HEADER -->
    <h1 class="inventory-title">Inventory</h1>

    <!-- FILTER & SEARCH BAR -->
    <div class="filter-search-container">
        <?= $this->Html->link(__('+ Add New Item'), ['action' => 'add'], ['class' => 'button add-item-btn']) ?>

        <div class="filter-group">
            <?= $this->Form->create(null, ['type' => 'get', 'class' => 'filter-form']) ?>
                <?= $this->Form->control('category', [
                    'label' => false,
                    'type' => 'select',
                    'options' => [
                        '' => 'All Categories',
                        'Major Equipment' => 'Major Equipment',
                        'Training & Conditioning Equipment' => 'Training & Conditioning Equipment',
                        'Facility & Maintenance Equipment' => 'Facility & Maintenance Equipment'
                    ],
                    'default' => $this->request->getQuery('category'),
                    'class' => 'filter-dropdown'
                ]) ?>
                
                <?= $this->Form->button(__('Filter'), ['class' => 'button filter-btn']) ?>
            <?= $this->Form->end() ?>
        </div>

        <!-- SEARCH BAR -->
        <div class="search-bar">
            <?= $this->Form->create(null, ['type' => 'get', 'class' => 'search-form']) ?>
                <?= $this->Form->control('search', [
                    'label' => false,
                    'placeholder' => 'Search item...',
                    'default' => $this->request->getQuery('search'),
                    'class' => 'search-input'
                ]) ?>
                <?= $this->Form->button(__('Search'), ['class' => 'button search-btn']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>

    <!-- CATEGORIZED INVENTORY LIST -->
    <?php 
    $categories = [
        'Major Equipment' => [],
        'Training & Conditioning Equipment' => [],
        'Facility & Maintenance Equipment' => []
    ];

    // Organize items into categories
    foreach ($items as $item) {
        $categories[$item->category][] = $item;
    }

    foreach ($categories as $categoryName => $categoryItems):
        if (!empty($categoryItems)): ?>
            <div class="category-section">
                <h2 class="category-title"><?= h($categoryName) ?></h2>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Item Name</th>
                                <th>Quantity</th>
                                <th>Condition</th>
                                <th>Date Added</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categoryItems as $item): ?>
                            <tr>
                                <td><?= $this->Number->format($item->id) ?></td>
                                <td><?= h($item->name) ?></td>
                                <td><?= $this->Number->format($item->quantity) ?></td>
                                <td><?= h($item->item_condition) ?></td>
                                <td><?= h($item->created->format('m/d/Y, h:i A')) ?></td>
                                <td class="actions">
                                    <div class="button-group">
                                        <?= $this->Html->link(__('View'), ['action' => 'view', $item->id], ['class' => 'button view-btn']) ?>
                                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $item->id], ['class' => 'button edit-btn']) ?>
                                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $item->id], [
                                            'confirm' => __('Are you sure you want to delete "{0}"?', $item->name), 
                                            'class' => 'button delete-btn'
                                        ]) ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif;
    endforeach; ?>
</div>
