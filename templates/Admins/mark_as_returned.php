<?= $this->Html->css('markAsReturned') ?>

<div class="mark-returned-container">
    <h1>Mark as Returned</h1>

    <p style="text-align: center; color: #555; font-size: 14.5px; margin-bottom: 30px;">
        Please indicate how many items were returned in good and damaged condition. Include remarks if necessary.
    </p>

    <?= $this->Form->create($request, ['url' => ['action' => 'markAsReturned', $request->id]]) ?>

        <div class="form-group">
            <?= $this->Form->label('returned_quantity', 'Returned (Good Condition)') ?>
            <?= $this->Form->control('returned_quantity', [
                'type' => 'number',
                'min' => 0,
                'max' => $request->quantity_requested,
                'default' => $request->quantity_requested,
                'label' => false,
                'class' => 'form-control',
                'id' => 'returned-quantity'
            ]) ?>
        </div>

        <div class="form-group">
            <?= $this->Form->label('damaged_quantity', 'Returned (Damaged)') ?>
            <?= $this->Form->control('damaged_quantity', [
                'type' => 'number',
                'min' => 0,
                'max' => $request->quantity_requested,
                'default' => 0,
                'label' => false,
                'class' => 'form-control',
                'id' => 'damaged-quantity'
            ]) ?>
        </div>

        <div class="form-group">
            <?= $this->Form->label('remark', 'Additional Remarks') ?>
            <?= $this->Form->control('remark', [
                'type' => 'text',
                'placeholder' => 'e.g. 1 item damaged due to tear',
                'label' => false,
                'class' => 'form-control'
            ]) ?>
        </div>

        <div class="form-group">
            <?= $this->Form->button('Submit', ['class' => 'btn submit']) ?>
        </div>

    <?= $this->Form->end() ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const returnedInput = document.getElementById('returned-quantity');
    const damagedInput = document.getElementById('damaged-quantity');
    const maxAllowed = <?= (int)$request->quantity_requested ?>;

    function validateTotal() {
        const returned = parseInt(returnedInput.value) || 0;
        const damaged = parseInt(damagedInput.value) || 0;
        const total = returned + damaged;

        if (total > maxAllowed) {
            alert(`The total returned items cannot exceed ${maxAllowed}.`);
            if (document.activeElement === damagedInput && returned <= maxAllowed) {
                damagedInput.value = maxAllowed - returned;
            } else if (document.activeElement === returnedInput && damaged <= maxAllowed) {
                returnedInput.value = maxAllowed - damaged;
            }
        }
    }

    returnedInput.addEventListener('input', validateTotal);
    damagedInput.addEventListener('input', validateTotal);
});
</script>
