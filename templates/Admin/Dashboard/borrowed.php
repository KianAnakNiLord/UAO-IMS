<div class="centered-container">
    <h1>Borrowed Items</h1>
    <div class="button-group">
        <?= $this->Html->link('Back to Admin Dashboard', ['controller' => 'Dashboard', 'action' => 'index'], ['class' => 'button green']) ?>
    </div>
    <?php if ($borrowed->isEmpty()): ?>
        <p>No borrowed items.</p>
    <?php else: ?>
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Borrower</th>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Borrowed Date</th>
                    <th>Return Date</th>
                    <th>Status</th>
                    <th>Rejection Note</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($borrowed as $request): ?>
                    <tr>
                        <td><?= $request->user ? h($request->user->name) : 'N/A' ?></td>
                        <td><?= $request->item ? h($request->item->name) : 'N/A' ?></td>
                        <td><?= h($request->quantity) ?></td>
                        <td><?= $request->borrowed_date ? h($request->borrowed_date->format('M d, Y')) : 'N/A' ?></td>
                        <td><?= $request->return_date ? h($request->return_date->format('M d, Y')) : 'N/A' ?></td>
                        <td><?= h($request->status) ?></td>
                        <td><?= $request->status === 'rejected' ? h($request->rejection_note) : 'N/A' ?></td>
                        <td>
                            <?= $this->Html->link('Mark as Returned', ['action' => 'return', $request->id], ['class' => 'button blue']) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>