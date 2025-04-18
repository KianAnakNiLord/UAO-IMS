<div class="register-wrapper">
    <div class="register-card">
        <h1 class="register-title">Create an Account</h1>

        <!-- ✅ Fix: start form BEFORE the inputs -->
        <?= $this->Form->create($user) ?>

            <?= $this->Form->control('name', [
                'label' => 'Full Name',
                'placeholder' => 'e.g. Juan dela Cruz',
                'class' => 'form-control' // ✅ Force consistent styling
            ]) ?>

            <?= $this->Form->control('email', [
                'label' => 'Email Address',
                'placeholder' => 'e.g. you@xu.edu.ph',
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
