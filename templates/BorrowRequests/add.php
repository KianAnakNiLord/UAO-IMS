<?= $this->Html->css('borrow_request_form') ?>
<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BorrowRequest $borrowRequest
 * @var array $flatInventory
 */
?>
<!-- 🔔 Error Message Box Centered in Form -->
<div id="errorPopup" style="
    display: none;
    margin: 0 auto;
    background: white;
    color: red;               /* changed to red */
    border: 2px solid red;
    padding: 16px 24px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    font-weight: bold;
    text-align: center;
    max-width: 90%;
    width: fit-content;
    margin-bottom: 1rem;
"></div>


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

                <!-- ✅ Flat Inventory Dropdown (with data-category and required) -->
                <div class="form-group">
                    <label for="inventorySelect">Inventory Item</label>
                    <select name="inventory_item_id" id="inventorySelect" class="form-control" required>
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
                    'min' => 1,
                    'required' => true
                ]) ?>

                <?= $this->Form->control('request_date', [
                    'label' => 'Request Date',
                    'empty' => true,
                    'required' => true
                ]) ?>

                <?= $this->Form->control('return_date', [
                    'label' => 'Return Date',
                    'empty' => true,
                    'required' => true
                ]) ?>

                <?= $this->Form->control('return_time', [
    'label' => 'Return Time',
    'type' => 'time',
    'empty' => true,
    'required' => true,
    'min' => '06:00',
    'max' => '17:00',
]) ?>


               <div class="form-group">
    <?= $this->Form->label('purpose', 'Purpose') ?>

    <div style="position: relative;">
        <?= $this->Form->textarea('purpose', [
            'id' => 'purpose',
            'placeholder' => 'State the reason for borrowing (max 100 characters)...',
            'required' => true,
            'maxlength' => 100,
            'style' => 'resize: none; margin-bottom: 2px;',
            'class' => 'form-control'
        ]) ?>
        <small id="charCount" style="
            display: block;
            margin: 0 4px;
            font-size: 13px;
            color: #666;
            font-style: italic;
        ">0 / 100</small>
    </div>
</div>




                <?= $this->Form->control('id_image', [
                    'type' => 'file',
                    'label' => 'Upload Student/Employee ID',
                    'accept' => 'image/*',
                    'required' => true
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
    const requestDateInput = document.getElementById('request-date');
    const returnDateInput = document.getElementById('return-date');
    const returnTimeInput = document.getElementById('return-time');
    const quantityInput = document.getElementById('quantity-requested');
    const purposeInput = document.getElementById('purpose');
    const charCountDisplay = document.getElementById('charCount');
    const form = document.querySelector('form');
    const errorPopup = document.getElementById('errorPopup');

    // ✅ Filter by category
    categoryFilter.addEventListener('change', function () {
        const selectedCategory = this.value;

        Array.from(inventorySelect.options).forEach(option => {
            if (!option.value) {
                option.style.display = 'block';
                return;
            }

            const itemCategory = option.getAttribute('data-category');
            option.style.display = (!selectedCategory || selectedCategory === itemCategory) ? 'block' : 'none';
        });

        inventorySelect.selectedIndex = 0;
        quantityInput.removeAttribute('max'); // Reset max
    });

    // ✅ Set dynamic max when inventory item changes
    inventorySelect.addEventListener('change', function () {
        const selectedOption = inventorySelect.options[inventorySelect.selectedIndex];
        const match = selectedOption?.textContent?.match(/\(Qty: (\d+)\)/);
        const availableQty = match ? parseInt(match[1]) : null;

        if (availableQty !== null) {
            quantityInput.setAttribute('max', availableQty);
        } else {
            quantityInput.removeAttribute('max');
        }
    });

    // ✅ Set min date to today
    const today = new Date().toISOString().split('T')[0];
    requestDateInput?.setAttribute('min', today);
    returnDateInput?.setAttribute('min', today);

    // ✅ Future return time check
    returnDateInput?.addEventListener('change', validateTimeLimit);
    returnTimeInput?.addEventListener('change', validateTimeLimit);

    function validateTimeLimit() {
        const returnDate = returnDateInput?.value;
        const returnTime = returnTimeInput?.value;

        if (!returnDate || !returnTime) return;

        const now = new Date();
        const selected = new Date(`${returnDate}T${returnTime}`);

        if (selected <= now) {
            showError("Return time must be in the future.");
            returnTimeInput.value = '';
        }
    }

    // ✅ Purpose live char count & warning
    purposeInput?.addEventListener('input', function () {
        const currentLength = purposeInput.value.length;
        charCountDisplay.textContent = `${currentLength} / 100`;

        if (currentLength > 100) {
            charCountDisplay.style.color = 'red';
            purposeInput.style.border = '2px solid red';
        } else {
            charCountDisplay.style.color = '#555';
            purposeInput.style.border = '';
        }
    });

    // ✅ Validate before submit
    form.addEventListener('submit', function (e) {
        let errorMessage = '';
        const selectedOption = inventorySelect.options[inventorySelect.selectedIndex];
        const selectedQtyText = selectedOption?.textContent?.match(/\(Qty: (\d+)\)/);
        const availableQty = selectedQtyText ? parseInt(selectedQtyText[1]) : null;
        const requestedQty = parseInt(quantityInput.value);
        const purposeLength = purposeInput?.value.length ?? 0;

        if (!inventorySelect.value) {
            errorMessage = 'Please select an inventory item.';
        } else if (isNaN(requestedQty) || requestedQty <= 0) {
            errorMessage = 'Quantity must be at least 1.';
        } else if (availableQty !== null && requestedQty > availableQty) {
            errorMessage = `Requested quantity exceeds available stock (${availableQty}).`;
        } else if (purposeLength > 100) {
            errorMessage = 'Purpose must not exceed 100 characters.';
        }

        if (errorMessage) {
            e.preventDefault();
            showError(errorMessage);
        }
    });

    // ✅ Error popup display
    function showError(message) {
        errorPopup.textContent = message;
        errorPopup.style.display = 'block';

        setTimeout(() => {
            errorPopup.style.display = 'none';
        }, 3000);
    }
    returnTimeInput?.addEventListener('input', function () {
    const val = returnTimeInput.value;
    if (val < '06:00' || val > '17:00') {
        showError('Return Time must be between 6:00 AM and 5:00 PM.');
        returnTimeInput.value = '';
    }
});

});
</script>
<?php if (!empty($fileUploadError)): ?>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    showError("<?= h($fileUploadError) ?>");
  });
</script>
<?php endif; ?>
