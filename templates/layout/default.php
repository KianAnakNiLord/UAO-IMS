<?php
/**
 * @var \App\View\AppView $this
 */
$cakeDescription = 'Sports Office IMS - Xavier University';

// Get controller and action
$controller = $this->request->getParam('controller');
$action = $this->request->getParam('action');

$hideNavbar = ($controller === 'Login' || ($controller === 'Register' && $action === 'index'));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $cakeDescription ?> | <?= $this->fetch('title') ?></title>
    
    <?= $this->Html->meta('icon') ?>
    <!-- Custom CSS -->
    <?= $this->Html->css(['style']) ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <!-- Navigation Bar -->
    <?php if (!$hideNavbar): ?>
    <nav class="navbar">
        <div class="nav-left">
            <a href="<?= $this->Url->build('/') ?>" class="logo">
                <?= $this->Html->image('cruslogo.png', ['alt' => 'Crusaders Logo']) ?>Sports Office IMS
            </a>
        </div>
        <div class="nav-right">
            <!-- Link to Pages/home -->
            <a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'home']) ?>">Home</a>
            <!-- Link to Login/index for logout -->
            <a href="<?= $this->Url->build(['controller' => 'Login', 'action' => 'logout']) ?>" class="logout-btn">Logout</a>
        </div>
    </nav>
    <?php endif; ?>
    <!-- Main Content -->
    <div class="container">
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
    </div>
    <!-- Footer -->
    <footer class="footer">
        <p>&copy; <?= date('Y') ?> Xavier University - Ateneo de Cagayan | Sports Office IMS</p>
    </footer>
</body>
</html>
