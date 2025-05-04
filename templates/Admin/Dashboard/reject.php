<div class="centered-container">
    <h1>Reject Borrow Request</h1>
    <p>Provide a reason for rejecting the borrow request:</p>

    <?= $this->Form->create($borrowing) ?>
        <fieldset>
            <legend><?= __('Rejection Note') ?></legend>
            <div class="form-group">
                <?= $this->Form->control('note', [
                    'type' => 'textarea',
                    'label' => 'Reason for Rejection',
                    'rows' => 4,
                    'class' => 'form-control',
                    'required' => true,
                ]) ?>
            </div>
        </fieldset>
        <div class="button-group">
            <?= $this->Form->button(__('Submit'), ['class' => 'button red']) ?>
            <?= $this->Html->link('Cancel', ['action' => 'index'], ['class' => 'button green']) ?>
        </div>
    <?= $this->Form->end() ?>
</div>