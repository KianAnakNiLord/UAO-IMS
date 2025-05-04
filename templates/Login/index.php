<?php
$this->assign('title', 'Login / Register');
?>

<?= $this->Html->css('styles') ?>

<div class="form-box active">
    <h2>Login</h2>

    <?php if (!empty($error)): ?>
        <div class="error-message"><?= h($error) ?></div>
    <?php endif; ?>

    <?= $this->Form->create(null) ?>
        <?= $this->Form->control('email', ['label' => false, 'placeholder' => 'Email']) ?>
        <?= $this->Form->control('password', ['label' => false, 'placeholder' => 'Password']) ?>
        <?= $this->Form->submit('Login', ['class' => 'custom-button']) ?>
    <?= $this->Form->end() ?>

    <p>Don’t have an account? <a href="<?= $this->Url->build(['controller' => 'Register', 'action' => 'index']) ?>">Register</a></p>
</div>
