<div class="card-container">
    <h1 class="section-title">Add New Borrower</h1>
    <!-- Borrower Form -->
    <?= $this->Form->create($borrower, ['class' => 'styled-form']) ?>
        <fieldset>
            <legend><?= __('Enter Borrower Details') ?></legend>
            <div class="form-group">
                <?= $this->Form->control('name', ['label' => 'Full Name', 'class' => 'form-control']) ?>
            </div>
            <div class="form-group">
                <?= $this->Form->control('email', ['label' => 'Email', 'class' => 'form-control']) ?>
            </div>
            <div class="form-group">
                <?= $this->Form->control('phone', ['label' => 'Phone Number', 'class' => 'form-control']) ?>
            </div>
        </fieldset>
        <div class="button-group">
            <?= $this->Form->button(__('Save Borrower'), ['class' => 'button blue']) ?>
        </div>
    <?= $this->Form->end() ?>
    <!-- Back Button -->
    <div class="button-group">
        <?= $this->Html->link('Back to Borrowers List', ['action' => 'index'], ['class' => 'button green']) ?>
    </div>
</div>