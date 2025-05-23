<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading">Actions</h4>
            <?= $this->Html->link('✏️ Edit User', ['action' => 'edit', $user->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink('🗑 Delete User', ['action' => 'delete', $user->id], [
                'confirm' => __('Are you sure you want to delete # {0}?', $user->id),
                'class' => 'side-nav-item'
            ]) ?>
            <?= $this->Html->link('📋 List Users', ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link('➕ New User', ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>

    <div class="column column-80">
        <div class="users view content">
            <h2 class="user-name"><?= h($user->name) ?></h2>
            <table class="user-details">
                <tr>
                    <th>Role</th>
                    <td><?= h($user->role) ?></td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td><?= h($user->name) ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?= h($user->email) ?></td>
                </tr>
                <tr>
                    <th>ID</th>
                    <td><?= $this->Number->format($user->id) ?></td>
                </tr>
                <tr>
                    <th>Created</th>
                    <td><?= h($user->created->format('F j, Y, g:i A')) ?></td>
                </tr>
                <tr>
                    <th>Modified</th>
                    <td><?= h($user->modified->format('F j, Y, g:i A')) ?></td>
                </tr>
            </table>

            <div class="related">
                <h3 class="related-title">📄 Related Borrow Requests</h3>
                <?php if (!empty($user->borrow_requests)) : ?>
                    <div class="table-responsive">
                        <table class="borrow-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User ID</th>
                                    <th>Inventory Item ID</th>
                                    <th>Status</th>
                                    <th>Request Date</th>
                                    <th>Return Date</th>
                                    <th>Created</th>
                                    <th>Modified</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($user->borrow_requests as $borrowRequest) : ?>
                                <tr>
                                    <td><?= h($borrowRequest->id) ?></td>
                                    <td><?= h($borrowRequest->user_id) ?></td>
                                    <td><?= h($borrowRequest->inventory_item_id) ?></td>
                                    <td><?= h(ucfirst($borrowRequest->status)) ?></td>
                                    <td><?= h($borrowRequest->request_date) ?></td>
                                    <td><?= h($borrowRequest->return_date) ?></td>
                                    <td><?= h($borrowRequest->created->format('n/j/y, g:i A')) ?></td>
                                    <td><?= h($borrowRequest->modified->format('n/j/y, g:i A')) ?></td>
                                    <td class="actions">
    <?= $this->Form->postLink('🗑 Delete', ['controller' => 'BorrowRequests', 'action' => 'delete', $borrowRequest->id], [
        'confirm' => __('Are you sure you want to delete # {0}?', $borrowRequest->id),
        'class' => 'btn delete'
    ]) ?>
</td>

                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else : ?>
                    <p class="empty-state">No borrow requests found for this user.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
/* === Titles === */
.user-name {
    font-size: 28px;
    font-weight: bold;
    color: #3A53A4;
    margin-bottom: 25px;
    border-left: 6px solid #B99433;
    padding-left: 15px;
}

.related-title {
    margin-top: 40px;
    font-size: 22px;
    color: #3A53A4;
    border-left: 5px solid #B99433;
    padding-left: 12px;
    margin-bottom: 16px;
}

/* === Detail Table === */
.user-details {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 40px;
}
.user-details th {
    background-color: #3A53A4;
    color: #fff;
    text-align: left;
    padding: 12px;
    width: 150px;
}
.user-details td {
    padding: 12px;
    background-color: #f9f9f9;
    border-bottom: 1px solid #ddd;
}

/* === Borrow Table === */
.borrow-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}
.borrow-table th {
    background-color: #3A53A4;
    color: #fff;
    padding: 10px;
    text-align: left;
}
.borrow-table td {
    padding: 10px;
    border-bottom: 1px solid #eee;
}
.borrow-table tr:hover {
    background-color: #f3f6fc;
}

/* === Buttons === */
.actions .btn {
    padding: 6px 10px;
    margin-right: 6px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 500;
    font-size: 13px;
    display: inline-block;
}
.actions .btn.view {
    background-color: #e3ecfc;
    color: #3A53A4;
}
.actions .btn.edit {
    background-color: #fff8e5;
    color: #B99433;
}
.actions .btn.delete {
    background-color: #fce2e3;
    color: #dc3545;
}
.actions .btn:hover {
    opacity: 0.9;
}

/* === Empty State === */
.empty-state {
    font-style: italic;
    color: #777;
    margin-top: 10px;
}

/* === Sidebar === */
.side-nav .heading {
    font-size: 18px;
    color: #3A53A4;
    margin-bottom: 10px;
}
.side-nav-item {
    display: block;
    margin: 6px 0;
    font-size: 14px;
    color: #3A53A4;
    text-decoration: none;
    font-weight: 500;
}
.side-nav-item:hover {
    text-decoration: underline;
}
</style>
