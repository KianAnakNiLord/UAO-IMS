<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Item $item
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete Item'),
                ['action' => 'delete', $item->id],
                ['confirm' => __('Are you sure you want to delete "{0}"?', $item->name), 'class' => 'side-nav-item delete-btn']
            ) ?>
            <?= $this->Html->link(__('Back to Inventory'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="items form content">
            <?= $this->Form->create($item) ?>
            <fieldset>
                <legend><?= __('Edit Item') ?></legend>
                <?php
                    echo $this->Form->control('name', ['label' => 'Item Name']);
                    echo $this->Form->control('description', ['label' => 'Description']);
                    echo $this->Form->control('quantity', ['label' => 'Quantity']);

                    // Dropdown for Category
                    echo $this->Form->control('category', [
                        'label' => 'Category',
                        'type' => 'select',
                        'options' => [
                            'Major Equipment' => 'Major Equipment',
                            'Training & Conditioning Equipment' => 'Training & Conditioning Equipment',
                            'Facility & Maintenance Equipment' => 'Facility & Maintenance Equipment'
                        ],
                        'empty' => 'Select a Category'
                    ]);

                    // Dropdown for Item Type (Specific Item)
                    echo $this->Form->control('item_type', [
                        'label' => 'Item Type',
                        'type' => 'select',
                        'options' => [
                            // Major Equipment
                            'Basketball' => 'Basketball',
                            'Volleyball' => 'Volleyball',
                            'Football' => 'Football',
                            'Badminton Racquet' => 'Badminton Racquet',
                            'Goal Net' => 'Goal Net',

                            // Training & Conditioning Equipment
                            'Cones' => 'Cones',
                            'Markers' => 'Markers',
                            'Agility Ladder' => 'Agility Ladder',
                            'Resistance Bands' => 'Resistance Bands',
                            'Jump Rope' => 'Jump Rope',
                            'Medicine Ball' => 'Medicine Ball',
                            'Dumbbell' => 'Dumbbell',

                            // Facility & Maintenance Equipment
                            'Scoreboard' => 'Scoreboard',
                            'Whistle' => 'Whistle',
                            'Stopwatch' => 'Stopwatch',
                            'Bleachers' => 'Bleachers',
                            'Bench' => 'Bench',
                            'Mats' => 'Mats',
                            'First Aid Kit' => 'First Aid Kit',
                            'Water Dispenser' => 'Water Dispenser'
                        ],
                        'empty' => 'Select an Item Type'
                    ]);

                    // Dropdown for Condition
                    echo $this->Form->control('item_condition', [
                        'label' => 'Condition',
                        'type' => 'select',
                        'options' => [
                            'New' => 'New',
                            'Good Condition' => 'Good Condition',
                            'Damaged' => 'Damaged'
                        ],
                        'empty' => 'Select Condition'
                    ]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Update Item'), ['class' => 'button']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
