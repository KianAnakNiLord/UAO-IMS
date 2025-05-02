<h1>Admin Dashboard</h1>

<!-- Display a personalized greeting for the admin -->
<p>Welcome, <?= h($this->request->getAttribute('identity')->name) ?>! You are logged in as an admin.</p>

<p>This is where UAO staff can manage all borrow requests and user data.</p>

<?= $this->Html->link('Logout', ['controller' => 'Users', 'action' => 'logout']) ?>
