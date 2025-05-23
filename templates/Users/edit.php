<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="edit-user-container">
    <h3 class="form-title">✏️ Edit User</h3>

    <?= $this->Form->create($user, ['class' => 'user-form']) ?>
        <div class="form-group">
            <?= $this->Form->label('name', 'Full Name') ?>
            <?= $this->Form->text('name', ['class' => 'form-control', 'required' => true]) ?>
        </div>

        <div class="form-group">
            <?= $this->Form->label('email', 'Email Address') ?>
            <?= $this->Form->email('email', ['class' => 'form-control', 'required' => true]) ?>
        </div>

        <div class="form-group">
            <?= $this->Form->label('password', 'New Password') ?>
            <?= $this->Form->password('password', ['class' => 'form-control']) ?>
            <small style="font-size: 12px; color: #777;">Leave blank to keep the current password</small>
        </div>

        <div class="form-group">
            <?= $this->Form->label('role', 'Role') ?>
            <?= $this->Form->select('role', [
                'admin' => 'Admin',
                'borrower' => 'Borrower'
            ], ['class' => 'form-control', 'empty' => '-- Select Role --', 'required' => true]) ?>
        </div>

        <div class="form-group">
            <?= $this->Form->label('is_verified', 'Verification Status') ?>
            <?= $this->Form->select('is_verified', [
                1 => 'Verified',
                0 => 'Unverified'
            ], ['class' => 'form-control', 'required' => true]) ?>
        </div>

        <div class="form-actions">
            <?= $this->Form->button(__('💾 Save Changes'), ['class' => 'btn-submit']) ?>
            <?= $this->Form->postLink(__('🗑 Delete User'), ['action' => 'delete', $user->id], [
                'confirm' => __('Are you sure you want to delete #{0}?', $user->id),
                'class' => 'btn-delete'
            ]) ?>
            <?= $this->Html->link('↩ Back to List', ['action' => 'index'], ['class' => 'btn-cancel']) ?>
        </div>
    <?= $this->Form->end() ?>
</div>

<style>
.edit-user-container {
    background-color: #ffffff;
    padding: 40px;
    border-radius: 14px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
    max-width: 800px;
    margin: 40px auto;
}

.form-title {
    font-size: 26px;
    color: #3A53A4;
    margin-bottom: 30px;
    border-left: 6px solid #B99433;
    padding-left: 15px;
}

.user-form .form-group {
    margin-bottom: 20px;
}

.user-form label {
    font-weight: 600;
    font-size: 14px;
    color: #3A53A4;
    margin-bottom: 6px;
    display: block;
}

.user-form .form-control {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 14px;
    box-sizing: border-box;
    transition: border-color 0.3s ease;
}

.user-form .form-control:focus {
    border-color: #B99433;
    outline: none;
}

.form-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-top: 30px;
}

.btn-submit {
    background-color: #3A53A4;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 8px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn-submit:hover {
    background-color: #2f418a;
}

.btn-cancel {
    background-color: #f0f0f0;
    color: #3A53A4;
    padding: 12px 20px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 15px;
    font-weight: 600;
    border: 1px solid #ccc;
}

.btn-cancel:hover {
    background-color: #e4e4e4;
}

.btn-delete {
    background-color: #dc3545;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 8px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn-delete:hover {
    background-color: #c82333;
}
</style>
