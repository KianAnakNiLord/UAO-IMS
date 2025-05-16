<?= $this->Html->css('dashboardAdmin') ?>

<div class="admin-dashboard">
    <h1>Admin Dashboard</h1>
    <p class="welcome">Welcome, <?= h($user->name) ?>! You are logged in as an administrator.</p>

    <div class="info-box">
        <h2>Quick Stats</h2>
        <ul>
            <li><strong>Total Inventory Items:</strong> <?= $totalItems ?></li>
            <li><strong>Pending Requests:</strong> <?= $pendingRequests ?></li>
            <li><strong>Approved Requests:</strong> <?= $approvedRequests ?></li>
            <li><strong>Returned:</strong> <?= $returnedRequests ?></li>
            <li><strong>Overdue:</strong> <?= $overdueRequests ?></li>
        </ul>
    </div>

    <div class="shortcuts">
        <h2>Quick Access</h2>
        <div class="buttons">
            <?= $this->Html->link('Manage Inventory', ['action' => 'inventory'], ['class' => 'btn shortcut']) ?>
            <?= $this->Html->link('Borrow Requests', ['action' => 'borrowRequests'], ['class' => 'btn shortcut']) ?>
            <?= $this->Html->link('Approved / Returned', ['action' => 'approvedRequests'], ['class' => 'btn shortcut']) ?>
            <?= $this->Html->link('Borrow History', ['action' => 'history'], ['class' => 'btn shortcut']) ?>
            <?= $this->Html->link('Export PDF', ['action' => 'exportInventoryPdf'], ['class' => 'btn shortcut']) ?>
        </div>
    </div>

    <div class="upcoming">
        <h2>Upcoming Returns (Next 3 Days)</h2>
        <?php if ($upcomingReturns->isEmpty()): ?>
            <p>No upcoming returns.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($upcomingReturns as $req): ?>
                    <li>
                        <strong><?= h($req->user->name) ?></strong> – 
                        <?= h($req->inventory_item->name) ?> (Due: <?= h($req->return_date) ?>)
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>

    <div class="notes">
        <h2>Admin Notes</h2>
        <ul>
            <li>Approve or reject requests under “Borrow Requests.”</li>
            <li>Returned items automatically update inventory quantity.</li>
            <li>Overdue status can be manually marked.</li>
            <li>Use “Export PDF” to print inventory records.</li>
        </ul>
    </div>
</div>
