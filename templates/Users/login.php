<div class="login-wrapper">
    <div class="login-card">
        <h1 class="login-title">Welcome to UAO-IMS</h1>

        <?= $this->Form->create() ?>
            <?= $this->Form->control('email', [
                'label' => 'Email Address',
                'placeholder' => 'e.g. yourname@xu.edu.ph'
            ]) ?>

            <?= $this->Form->control('password', [
                'label' => 'Password',
                'placeholder' => 'Enter your password'
            ]) ?>

            <?= $this->Form->button('Login', ['class' => 'login-btn']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
