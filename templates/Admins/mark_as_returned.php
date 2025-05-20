<?= $this->Html->css('markAsReturned') ?>

<h1>Mark as Returned</h1>

<p>Mark the borrow request as returned and indicate the quantity returned in good and damaged condition.</p>

<?= $this->Form->create($request, ['url' => ['action' => 'markAsReturned', $request->id]]) ?>

    <div class="form-group">
        <label>Returned (Good Condition)</label>
        <?= $this->Form->control('returned_quantity', [
            'type' => 'number',
            'min' => 0,
            'max' => $request->quantity_requested,
            'default' => $request->quantity_requested,
            'label' => false,
            'class' => 'form-control'
        ]) ?>
    </div>

    <div class="form-group">
        <label>Returned (Damaged)</label>
        <?= $this->Form->control('damaged_quantity', [
            'type' => 'number',
            'min' => 0,
            'max' => $request->quantity_requested,
            'default' => 0,
            'label' => false,
            'class' => 'form-control'
        ]) ?>
    </div>

    <div class="form-group">
        <label>Additional Remarks</label>
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
            // Auto-fix by adjusting damaged down
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
