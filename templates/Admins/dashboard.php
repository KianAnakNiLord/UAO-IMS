<?= $this->Html->css('dashboardAdmin') ?>

<div class="admin-dashboard">
    <h1 class="dashboard-title">Admin Dashboard</h1>
    <p class="welcome-msg">Welcome, <strong><?= h($user->name) ?></strong>! You are logged in as an administrator.</p>

    <!-- 🔢 Quick Stats -->
    <div class="card-section">
        <h2 class="section-title">Quick Stats</h2>
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Inventory</h3>
                <p><?= $totalItems ?></p>
            </div>
            <div class="stat-card">
                <h3>Pending</h3>
                <p><?= $pendingRequests ?></p>
            </div>
            <div class="stat-card">
                <h3>Approved</h3>
                <p><?= $approvedRequests ?></p>
            </div>
            <div class="stat-card">
                <h3>Returned</h3>
                <p><?= $returnedRequests ?></p>
            </div>
            <div class="stat-card">
                <h3>Overdue</h3>
                <p><?= $overdueRequests ?></p>
            </div>
        </div>
    </div>

    <!-- 🚀 Quick Access -->
    <div class="card-section">
        <h2 class="section-title">Quick Access</h2>
        <div class="shortcut-grid">
            <?= $this->Html->link('Manage Inventory', ['action' => 'inventory'], ['class' => 'btn shortcut']) ?>
            <?= $this->Html->link('Borrow Requests', ['action' => 'borrowRequests'], ['class' => 'btn shortcut']) ?>
            <?= $this->Html->link('Approved / Returned', ['action' => 'approvedRequests'], ['class' => 'btn shortcut']) ?>
            <?= $this->Html->link('Borrow History', ['action' => 'history'], ['class' => 'btn shortcut']) ?>
            <?= $this->Html->link('Export PDF', ['action' => 'exportInventoryPdf'], ['class' => 'btn shortcut']) ?>
        </div>
    </div>

    <!-- ⏰ Upcoming Returns -->
    <div class="card-section">
        <h2 class="section-title">Upcoming Returns (Next 3 Days)</h2>
        <?php if ($upcomingReturns->isEmpty()): ?>
            <p class="empty-state">No upcoming returns.</p>
        <?php else: ?>
            <ul class="upcoming-list">
                <?php foreach ($upcomingReturns as $req): ?>
                    <li>
                        <strong><?= h($req->user->name) ?></strong> –
                        <?= h($req->inventory_item->name) ?> 
                        <span class="due-date">(Due: <?= h($req->return_date) ?>)</span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>

    <!-- 📌 Notes -->
    <div class="card-section">
        <h2 class="section-title">Admin Notes</h2>
        <ul class="admin-notes">
            <li>Approve or reject requests under “Borrow Requests.”</li>
            <li>Returned items automatically update inventory quantity.</li>
            <li>Use “Export PDF” to print inventory records.</li>
        </ul>
    </div>
</div>
