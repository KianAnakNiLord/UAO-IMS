<?= $this->Html->css('markAsReturned') ?>

<h1>Mark as Returned</h1>

<p>Mark the borrow request as returned and provide a remark.</p>

<!-- Form to choose the remark for returned item -->
<?= $this->Form->create($request, ['url' => ['action' => 'markAsReturned', $request->id]]) ?>
    <div class="form-group">
        <label for="returned_quantity">Number of items returned in good condition:</label>
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
        <label for="remark">Remarks (e.g. 1 damaged):</label>
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

