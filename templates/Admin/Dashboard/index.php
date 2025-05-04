<h1>Pending Borrowing Requests</h1>
<div class="centered-container">
    <h1>Pending Borrowing Requests</h1>
    <?php if ($pending->isEmpty()): ?>
        <p>No pending borrowing requests.</p>
        <div class="button-group">
            <?= $this->Html->link('View Borrowed Items', ['controller' => 'Dashboard', 'action' => 'borrowed'], ['class' => 'button blue']) ?>
            <?= $this->Html->link('View Item Status', ['controller' => 'Dashboard', 'action' => 'itemsStatus'], ['class' => 'button blue']) ?>
        </div>
    <?php else: ?>
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Borrower</th>
                    <th>Item</th>
                    <th>Borrowed Date</th>
                    <th>Return Date</th>
                    <th>Attachment</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pending as $request): ?>
                <tr>
                    <td><?= h($request->user->name) ?></td> <!-- Updated to use the Users association -->
                    <td><?= h($request->item->name) ?></td>
                    <td><?= $request->borrowed_date ? h($request->borrowed_date->format('M d, Y')) : 'N/A' ?></td>
                    <td><?= $request->return_date ? h($request->return_date->format('M d, Y')) : 'N/A' ?></td>
                    <td>
                        <?php if ($request->attachment): ?>
                            <?= $this->Html->link('View Attachment', '/files/attachments/' . $request->attachment, ['target' => '_blank', 'class' => 'action-link']) ?>
                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                    <td>
                        <?= $this->Html->link('Approve', ['action' => 'approve', $request->id], ['class' => 'button green']) ?>
                        <?= $this->Html->link('Reject', ['action' => 'reject', $request->id], ['class' => 'button red']) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>