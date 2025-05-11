<div class="login-wrapper">
    <div class="login-card">
        <h1 class="login-title">Welcome to UAO-IMS</h1>

        <?= $this->Form->create() ?>
            <?= $this->Form->control('email', [
                'label' => 'Email Address',
                'placeholder' => 'e.g. yourname@xu.edu.ph',
                'class' => 'form-control'
            ]) ?>

<div class="password-wrapper">
    <label for="passwordInput">Password</label>
    <input type="password" name="password" id="passwordInput" class="form-control" placeholder="Enter your password">
    <span id="togglePassword" class="toggle-password">
        <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#3A53A4" viewBox="0 0 16 16">
            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zm-8 4a4 4 0 1 1 0-8 4 4 0 0 1 0 8z"/>
            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5z"/>
        </svg>
    </span>
</div>


            <?= $this->Form->button('Login', ['class' => 'login-btn']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const passwordInput = document.getElementById("passwordInput");
        const toggleIcon = document.getElementById("togglePassword");
        let eyeVisible = true;

        toggleIcon.addEventListener("click", function () {
            const type = passwordInput.type === "password" ? "text" : "password";
            passwordInput.type = type;
            eyeVisible = !eyeVisible;
            toggleIcon.innerHTML = eyeVisible
                ? `<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#3A53A4" viewBox="0 0 16 16">
                     <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zm-8 4a4 4 0 1 1 0-8 4 4 0 0 1 0 8z"/>
                     <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5z"/>
                   </svg>`
                : `<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#3A53A4" viewBox="0 0 16 16">
                     <path d="M13.359 11.238C14.417 10.074 15 8.777 15 8s-.583-2.074-1.641-3.238C12.3 3.602 10.287 2.5 8 2.5c-.97 0-1.906.176-2.758.484l1.47 1.47A4.5 4.5 0 0 1 12.5 8c0 .818-.246 1.578-.667 2.21l1.526 1.528z"/>
                     <path d="M2.854 2.146a.5.5 0 1 0-.708.708l1.311 1.311A9.77 9.77 0 0 0 1 8s3 5.5 7 5.5a7.24 7.24 0 0 0 2.566-.474l1.08 1.08a.5.5 0 0 0 .708-.708l-10-10zM5.682 5.682l1.312 1.312A1.5 1.5 0 0 0 8 9.5c.333 0 .643-.105.9-.282l1.24 1.24A4.5 4.5 0 0 1 4.5 8c0-.736.184-1.43.504-2.04z"/>
                   </svg>`;
        });
    });
</script>
