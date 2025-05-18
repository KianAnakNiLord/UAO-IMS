<div class="verify-wrapper">
    <div class="verify-card">
        <h1>Email Verification</h1>
        <p>We’ve sent a 6-digit OTP to <strong><?= h($user->email) ?></strong>. Please enter it below:</p>

        <?= $this->Form->create() ?>
            <?= $this->Form->control('otp', [
                'label' => 'Enter OTP Code',
                'placeholder' => 'e.g. 123456',
                'required' => true,
                'maxlength' => 6,
                'class' => 'form-control'
            ]) ?>
            <?= $this->Form->button('Verify', ['class' => 'btn primary-btn']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
