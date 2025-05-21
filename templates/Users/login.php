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
            Access the system using your <strong>@my.xu.edu.ph</strong> account
        </p>

        <!-- 🔐 Google Login -->
        <?= $this->Html->link(
            'Login with Google',
            ['plugin' => 'ADmad/SocialAuth', 'controller' => 'Auth', 'action' => 'login', 'google'],
            ['class' => 'login-btn']
        ) ?>

        <!-- 📝 Footer -->
        <div class="login-footer">
            <p>© <?= date('Y') ?> University Athletics Office - Xavier University</p>
        </div>
    </div>
</div>

<style>
    /* 🔵 Layout */
    .login-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background-color: #f0f2f8;
        padding: 20px;
    }

    .login-card {
        background: white;
        padding: 60px 40px;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.12);
        max-width: 420px;
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

    /* 🔘 Login Button */
    .login-btn {
        background-color: white;
        border: 2px solid #3A53A4;
        color: #3A53A4;
        padding: 14px;
        font-size: 15px;
        font-weight: 600;
        border-radius: 8px;
        display: inline-block;
        width: 100%;
        text-decoration: none;
        transition: all 0.3s ease;
        margin-left: -15px; /* tweak value as needed */
        box-shadow: 0 2px 6px rgba(58, 83, 164, 0.1);
    }

    .login-btn:hover {
        background-color: #3A53A4;
        color: white;
    }

    /* 📌 Footer */
    .login-footer {
        margin-top: 40px;
        font-size: 12px;
        color: #999;
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
