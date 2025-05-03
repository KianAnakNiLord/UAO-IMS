<?= $this->Html->css('markAsReturned') ?>

<h1>Mark as Returned</h1>

<p>Mark the borrow request as returned and provide a remark.</p>

<!-- Form to choose the remark for returned item -->
<?= $this->Form->create($request, ['url' => ['action' => 'markAsReturned', $request->id]]) ?>
    <div class="form-group">
        <label for="remark">Select Remark</label>
        <?= $this->Form->control('remark', [
            'type' => 'select',
            'options' => ['returned_as_is' => 'Returned as is', 'damaged' => 'Damaged'],
            'empty' => 'Choose remark',
            'class' => 'form-control',
        ]) ?>
    </div>

    <div class="form-group">
        <?= $this->Form->button('Submit', ['class' => 'btn submit']) ?>
    </div>
<?= $this->Form->end() ?>
