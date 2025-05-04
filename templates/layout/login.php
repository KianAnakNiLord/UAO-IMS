<!-- templates/layout/login.php -->
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <title><?= $this->fetch('title') ?></title>
    <?= $this->Html->css('styles') ?>
</head>
<body>
    <main>
        <?= $this->fetch('content') ?>
    </main>
</body>
</html>
