<div class="login-wrapper">
    <div class="login-card">

        <!-- 🔰 Logo -->
        <div class="login-logo">
            <img src="<?= $this->Url->image('cruslogo.png') ?>" class="logo" alt="UAO Logo">
        </div>

        <!-- 🔷 Title -->
        <h1 class="login-title">
            Welcome to <span class="highlight">UAO-IMS</span>
        </h1>

        <!-- 📎 Subtext -->
        <p class="login-subtext">
            Access the system using your <strong>@my.xu.edu.ph</strong> account or login as admin
        </p>

        <!-- 🔐 Google Login -->
        <?= $this->Html->link(
            'Login with Google',
            ['plugin' => 'ADmad/SocialAuth', 'controller' => 'Auth', 'action' => 'login', 'google'],
            ['class' => 'login-btn']
        ) ?>

        <!-- 🔻 Divider -->
        <div style="text-align: center; margin: 25px 0 20px; color: #999;">or</div>

        <!-- 🧑‍💼 Manual Admin Login Form -->
        <?= $this->Form->create() ?>

            <!-- Email Field -->
            <div class="form-group">
    <label for="emailInput" class="form-label">Email Address</label>
    <input type="email" name="email" id="emailInput" class="form-control" placeholder="e.g. admin@example.com" required>
</div>


            <!-- Password Field with Toggle -->
            <div class="password-wrapper">
                <label for="passwordInput" class="form-label">Password</label>

                <input type="password" name="password" id="passwordInput" class="form-control" placeholder="Enter your password" required>
                <span id="togglePassword" class="toggle-password">
                    <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#3A53A4" viewBox="0 0 16 16">
                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zm-8 4a4 4 0 1 1 0-8 4 4 0 0 1 0 8z"/>
                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5z"/>
                    </svg>
                </span>
            </div>

            <!-- Submit Button -->
            <?= $this->Form->button('Login', ['class' => 'login-btn']) ?>
        <?= $this->Form->end() ?>

        <!-- 📄 Footer -->
        <div class="login-footer">
            <p>© <?= date('Y') ?> University Athletics Office - Xavier University</p>
        </div>
    </div>
</div>

<style>
    /* 🔵 Layout */
    body {
        background-color: #f5f7fa;
        font-family: 'Segoe UI', sans-serif;
        margin: 0;
        padding: 0;
    }

    .login-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background-color: #f0f2f8;
        padding: 20px;
        transform: translateX(-30px); /* fix offset */
    }

    .login-card {
        background: white;
        padding: 60px 40px;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.12);
        max-width: 450px;
        width: 100%;
        text-align: center;
        animation: fadeIn 0.6s ease-out;
    }

    /* 🖼️ Logo */
    .login-logo {
        margin-bottom: 30px;
    }

    .login-logo img {
        max-height: 90px;
        display: block;
        margin: 0 auto;
    }

    /* 🏫 Title and Subtext */
    .login-title {
        font-size: 26px;
        font-weight: 700;
        margin-bottom: 10px;
        color: #3A53A4;
    }

    .highlight {
        color: #B99433;
    }

    .login-subtext {
        font-size: 15px;
        color: #555;
        margin-bottom: 35px;
    }

    /* 🔘 Buttons */
    .login-btn {
        background-color: #3A53A4;
        color: white;
        border: none;
        width: 100%;
        padding: 12px 15px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 16px;
        transition: background 0.3s ease;
        margin-top: 10px;
        text-decoration: none; /* 🔥 remove underline */
    }

    .login-btn:hover {
        background-color: #a07f29;
    }

    /* 📌 Footer */
    .login-footer {
        margin-top: 40px;
        font-size: 12px;
        color: #999;
    }

    /* 👁️ Show/Hide Password Eye Icon */
    .password-wrapper {
        position: relative;
        margin-bottom: 20px;
        text-align: left;
        
    }

    .password-wrapper input.form-control {
        padding-right: 15px !important;
    }

    .toggle-password {
        position: absolute;
        top: 50%;
        right: 12px;
        transform: translateY(-50%);
        cursor: pointer;
    }

    /* 🧾 Form Fields */
    input.form-control {
        width: 92%;
        padding: 12px 15px;
        font-size: 15px;
        border: 1px solid #ccc;
        border-radius: 6px;
        background-color: #f0f4ff;
        margin-bottom: 20px;
        outline: none;
        transition: border-color 0.3s ease;
    }

    input.form-control:focus {
        border-color: #3A53A4;
    }
    .form-group {
    text-align: left;
    margin-bottom: 20px;
}

.form-label {
    display: block;
    margin-bottom: 6px;
    font-weight: 500;
    color: #333;
}


    /* ✨ Animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* 📱 Mobile responsiveness */
    @media (max-width: 500px) {
        .login-card {
            padding: 40px 25px;
        }

        .login-title {
            font-size: 22px;
        }

        .login-btn {
            font-size: 14px;
        }

        .login-logo img {
            max-height: 75px;
        }
    }
</style>

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
                     <path d="M2.854 2.146a.5.5 0 1 0-.708.708l1.311 1.311A9.77 9.77 0 0 0 1 8s3 5.5 7 5.5a7.24 7.24 0 0 0 2.566-.474l1.08 1.08a.5.5 0 0 0 .708-.708l-10-10z"/>
                   </svg>`;
        });
    });
</script>
