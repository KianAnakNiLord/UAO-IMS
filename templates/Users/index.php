<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\User> $users
 */
?>
<?= $this->Html->css('users_index') ?> <!-- Optional external CSS -->

<div class="users index content">
    <?= $this->Html->link(__('➕ New User'), ['action' => 'add'], ['class' => 'btn-new-user']) ?>
    <h3 class="users-title"><?= __('Manage Users') ?></h3>

    <div class="table-container">
        <table class="users-table">
            <thead>
    <tr>
        <th>ID</th>
        <th>Role</th>
        <th>Name</th>
        <th>Email</th>
        <th>Created</th>
        <th>Modified</th>
        <th class="actions">Actions</th>
    </tr>
</thead>

            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $this->Number->format($user->id) ?></td>
                    <td>
                        <span class="role-badge <?= $user->role === 'admin' ? 'admin' : 'borrower' ?>">
                            <?= h(ucfirst($user->role)) ?>
                        </span>
                    </td>
                    <td><?= h($user->name) ?></td>
                    <td><?= h($user->email) ?></td>
                    
                    <td><?= h($user->created->format('n/j/y, g:i A')) ?></td>
                    <td><?= h($user->modified->format('n/j/y, g:i A')) ?></td>
                    <td class="actions">
                        <?= $this->Html->link('🔍 View', ['action' => 'view', $user->id], ['class' => 'btn view']) ?>
                        <?= $this->Html->link('✏️ Edit', ['action' => 'edit', $user->id], ['class' => 'btn edit']) ?>
                        <?= $this->Form->postLink(
                            '🗑 Delete',
                            ['action' => 'delete', $user->id],
                            [
                                'confirm' => __('Are you sure you want to delete user #{0}?', $user->id),
                                'class' => 'btn delete'
                            ]
                        ) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('« First') ?>
            <?= $this->Paginator->prev('‹ Prev') ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next('Next ›') ?>
            <?= $this->Paginator->last('Last »') ?>
        </ul>
        <p class="pagination-summary">
            <?= $this->Paginator->counter('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total') ?>
        </p>
    </div>
</div>

<style>
/* 📦 Container */
.users.index.content {
    padding: 40px;
    background-color: #fff;
    border-radius: 14px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
    max-width: 100%;
}

/* 🎯 Header and Button */
.users-title {
    color: #3A53A4;
    font-size: 26px;
    border-left: 6px solid #B99433;
    padding-left: 15px;
    margin-bottom: 30px;
}

.btn-new-user {
    float: right;
    background-color: #3A53A4;
    color: white;
    padding: 10px 18px;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    margin-bottom: 15px;
}
.btn-new-user:hover {
    background-color: #2f418a;
}

/* 📊 Table Styling */
.users-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
    font-size: 14px;
}
.users-table th {
    background-color: #3A53A4;
    color: white;
    padding: 12px;
    text-align: left;
}
.users-table td {
    padding: 12px;
    border-bottom: 1px solid #e0e0e0;
}
.users-table tbody tr:hover {
    background-color: #f9f9f9;
}

/* 🏷️ Role Badge */
.role-badge {
    padding: 6px 10px;
    border-radius: 6px;
    font-weight: bold;
    text-transform: uppercase;
    font-size: 12px;
    display: inline-block;
}
.role-badge.admin {
    background-color: #fff3e4;
    color: #B99433;
}
.role-badge.borrower {
    background-color: #e7f0ff;
    color: #3A53A4;
}

/* 🛠 Action Buttons */
.actions .btn {
    padding: 6px 10px;
    margin-right: 6px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 500;
    font-size: 13px;
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

/* 📎 Pagination */
.paginator {
    margin-top: 30px;
    text-align: center;
}
.pagination {
    display: inline-flex;
    gap: 8px;
    list-style: none;
    padding: 0;
}
.pagination li {
    padding: 8px 14px;
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 14px;
    color: #3A53A4;
}
.pagination li:hover {
    background-color: #B99433;
    color: white;
    cursor: pointer;
}
.pagination-summary {
    margin-top: 10px;
    font-size: 13px;
    color: #777;
}
</style>
