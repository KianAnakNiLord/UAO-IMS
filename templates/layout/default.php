<?php
/**
 * @var \App\View\AppView $this
 */
$cakeDescription = 'Sports Office IMS - Xavier University';
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
    <nav class="navbar">
        <div class="nav-left">
            <a href="<?= $this->Url->build('/') ?>" class="logo">Sports Office IMS</a>
        </div>
        <div class="nav-right">
            <a href="<?= $this->Url->build('/') ?>">Home</a>
            <a href="<?= $this->Url->build('/items') ?>">Inventory</a>
            <a href="<?= $this->Url->build('/users/logout') ?>" class="logout-btn">Logout</a>
        </div>
    </nav>

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
