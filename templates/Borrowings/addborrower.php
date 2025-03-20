<h1>Add New Borrower</h1>

<?= $this->Form->create($borrower) ?>
    <fieldset>
        <legend><?= __('Enter Borrower Details') ?></legend>
        <?= $this->Form->control('name', ['label' => 'Full Name']) ?>
        <?= $this->Form->control('email', ['label' => 'Email']) ?>
        <?= $this->Form->control('phone', ['label' => 'Phone Number']) ?>
    </fieldset>

    <?= $this->Form->button(__('Save Borrower')) ?>
<?= $this->Form->end() ?>

<?= $this->Html->link(__('Back to Borrowers List'), ['action' => 'index'], ['class' => 'button']) ?>
