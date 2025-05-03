<div class="register-wrapper">
    <div class="register-card">
        <h1 class="register-title">Create an Account</h1>

        <?= $this->Form->create($user) ?>

            <?= $this->Form->control('name', [
                'label' => 'Full Name',
                'placeholder' => 'e.g. Lebron James',
                'class' => 'form-control'
            ]) ?>

            <?= $this->Form->control('email', [
                'label' => 'Email Address',
                'placeholder' => 'e.g. 2xxxxxxxxx@xu.edu.ph',
                'class' => 'form-control'
            ]) ?>

            <?= $this->Form->control('password', [
                'label' => 'Password',
                'placeholder' => 'Create a strong password',
                'class' => 'form-control'
            ]) ?>

            <?= $this->Form->button('Register', ['class' => 'register-btn']) ?>

        <?= $this->Form->end() ?>

        <p class="form-footer">
            Already have an account?
            <a href="<?= $this->Url->build(['action' => 'login']) ?>">Login here</a>
        </p>
    </div>
</div>
