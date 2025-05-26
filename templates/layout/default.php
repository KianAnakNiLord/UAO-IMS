<?php
$identity = $this->request->getAttribute('identity');
$role = $identity ? $identity->get('role') : null;
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= h($this->fetch('title')) ?></title>
    <?= $this->Html->css(['style']) ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
    <?= $this->Html->css('login') ?>
</head>
<body>
<div class="layout">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <!-- 🟦 Logo Image -->
            <?= $this->Html->image('cruslogo.png', [
                'alt' => 'UAO Logo',
                'style' => 'max-width: 100px; display: block; margin: 0 auto 10px;'
            ]) ?>
            <h2 style="color: white; text-align: center;">Univeristy Athletics Office</h2>
        </div>

        <nav class="nav-links">
            <?php if ($identity): ?>
                <?php if ($role === 'admin'): ?>
                    <?= $this->Html->link('Dashboard', '/admins/dashboard', ['class' => 'nav-item']) ?>
                    <?= $this->Html->link('Inventory', '/admins/inventory', ['class' => 'nav-item']) ?>
                    <?= $this->Html->link('Borrow Requests', '/admins/borrowRequests', ['class' => 'nav-item']) ?>
                    <?= $this->Html->link('Approved Requests', '/admins/approvedRequests', ['class' => 'nav-item']) ?>
                    <?= $this->Html->link('Borrow History', '/admins/history', ['class' => 'nav-item']) ?>
                    <?= $this->Html->link('Manage Users', ['controller' => 'Users', 'action' => 'index'], ['class' => 'nav-item']) ?>
                <?php elseif ($role === 'borrower'): ?>
                    <?= $this->Html->link('Dashboard', '/borrowers/dashboard', ['class' => 'nav-item']) ?>
                    <?= $this->Html->link('New Borrow Request', '/borrowRequests/add', ['class' => 'nav-item']) ?>
                    <?= $this->Html->link('My Requests', '/borrowRequests/index', ['class' => 'nav-item']) ?>
                <?php endif; ?>
                <?= $this->Html->link('Logout', '/users/logout', ['class' => 'nav-item logout']) ?>
            <?php else: ?>
                <?= $this->Html->link('Login', '/users/login', ['class' => 'nav-item']) ?>
                
            <?php endif; ?>
        </nav>
    </aside>

    <!-- Main content -->
    <main class="main-content">
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
    </main>
</div>
</body>
</html>
