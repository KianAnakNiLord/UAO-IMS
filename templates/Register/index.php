<?php
$this->assign('title', 'Register');
?>

<?= $this->Html->css('styles') ?>

<div class="form-box active">
    <h2>Register</h2>
    <?= $this->Form->create($user) ?>
        <?= $this->Form->control('name', ['label' => false, 'placeholder' => 'Full Name']) ?>
        <?= $this->Form->control('email', ['label' => false, 'placeholder' => 'Email']) ?>
        <?= $this->Form->control('password', ['label' => false, 'placeholder' => 'Password', 'type' => 'password']) ?>
        <?= $this->Form->submit('Register') ?>
    <?= $this->Form->end() ?>
    <p>Already have an account? <a href="<?= $this->Url->build(['controller' => 'Login', 'action' => 'index']) ?>">Login</a></p>
</div>