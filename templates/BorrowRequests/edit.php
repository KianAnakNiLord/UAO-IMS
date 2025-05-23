<?= $this->Html->css('borrow_request_form') ?>

<!-- 🔔 Error Box Centered in Form -->
<?php if (!empty($borrowRequest->getErrors())): ?>
    <div style="
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
        border-radius: 6px;
        padding: 12px 16px;
        max-width: 80%;
        margin: 10px auto 20px auto;
        text-align: center;
        font-weight: bold;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    ">
        ⚠️ Please correct the highlighted errors before submitting.
    </div>
<?php endif; ?>

<style>
.form-error {
    border: 2px solid #dc3545 !important;
    background-color: #fff5f5 !important;
    box-shadow: 0 0 6px rgba(220, 53, 69, 0.3) !important;
}
</style>

<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $borrowRequest->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $borrowRequest->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Borrow Requests'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>

    <div class="column column-80">
        <div class="borrowRequests form content">
            <?= $this->Flash->render() ?>
            <?= $this->Form->create($borrowRequest, ['type' => 'file']) ?>
            <fieldset>
                <legend><?= __('Edit Borrow Request') ?></legend>

                <!-- Inventory dropdown -->
                <div class="form-group">
                    <?= $this->Form->label('inventory_item_id', 'Inventory Item') ?>
                    <select name="inventory_item_id"
                            class="form-control <?= !empty($borrowRequest->getError('inventory_item_id')) ? 'form-error' : '' ?>" required>
                        <option value="">-- Select Item --</option>
                        <?php foreach ($flatInventory as $item): ?>
                            <option value="<?= h($item->id) ?>" <?= $borrowRequest->inventory_item_id === $item->id ? 'selected' : '' ?>>
                                <?= h($item->name) ?> (Qty: <?= h($item->quantity) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?= $this->Form->error('inventory_item_id') ?>
                </div>

                <!-- Other Fields -->
                <?php
                $fields = [
                    'quantity_requested' => 'Quantity',
                    'request_date' => 'Request Date',
                    'return_date' => 'Return Date',
                    'return_time' => 'Return Time',
                    'purpose' => 'Purpose'
                ];

                foreach ($fields as $field => $label) {
                    $type = match ($field) {
                        'quantity_requested' => 'number',
                        'request_date', 'return_date' => 'date',
                        'return_time' => 'time',
                        'purpose' => 'textarea',
                        default => 'text'
                    };

                    echo $this->Form->control($field, [
                        'label' => $label,
                        'type' => $type,
                        'templates' => false,
                        'class' => 'form-control' . (!empty($borrowRequest->getError($field)) ? ' form-error' : ''),
                        'min' => $field === 'quantity_requested' ? 1 : null,
                        'maxlength' => $field === 'purpose' ? 100 : null,
                        'required' => true
                    ]);
                    echo $this->Form->error($field);
                }
                ?>

                <!-- Optional ID Image Upload -->
                <?= $this->Form->control('id_image', [
                    'type' => 'file',
                    'label' => 'Change ID Image (optional)',
                    'accept' => 'image/*',
                    'required' => false,
                    'templates' => false,
                    'class' => 'form-control' . (!empty($borrowRequest->getError('id_image')) ? ' form-error' : '')
                ]) ?>
                <?= $this->Form->error('id_image') ?>

                <!-- Show existing photo preview -->
                <?php if (!empty($borrowRequest->id_image)): ?>
                    <div style="margin-top: 10px;">
                        <small>Current ID Image:</small><br>
                        <img src="<?= $this->Url->build('/' . $borrowRequest->id_image) ?>" alt="Current ID Image" width="100" style="border:1px solid #ccc; border-radius: 6px;">
                    </div>
                <?php endif; ?>
            </fieldset>

            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<!-- ✅ Prevent past date selection -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const today = new Date().toISOString().split('T')[0];
        document.querySelector('[name="request_date"]').min = today;
        document.querySelector('[name="return_date"]').min = today;
    });
</script>
