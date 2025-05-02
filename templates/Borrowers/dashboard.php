<h1 style="color:#B99433;">Borrower Dashboard</h1>

<!-- Display a personalized greeting -->
<p>Hello, <?= h($this->request->getAttribute('identity')->name) ?>! Welcome to your dashboard.</p>

<p>This is where students/employees can see their info.</p>

<?= $this->Html->link('Logout', ['controller' => 'Users', 'action' => 'logout']) ?>
