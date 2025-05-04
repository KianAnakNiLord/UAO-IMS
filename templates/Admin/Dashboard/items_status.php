<div class="centered-container">
    <h1>Item Status</h1>
    <div class="button-group">
        <?= $this->Html->link('Back to Admin Dashboard', ['controller' => 'Dashboard', 'action' => 'index'], ['class' => 'button green']) ?>
    </div>
    <?php if ($borrowings->isEmpty()): ?>
        <p>No items are currently borrowed or pending approval.</p>
    <?php else: ?>
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Borrower</th>
                    <th>Quantity Borrowed</th>
                    <th>Borrowed Date</th>
                    <th>Return Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($borrowings as $borrowing): ?>
                    <tr>
                        <td><?= h($borrowing->item->name) ?></td>
                        <td><?= h($borrowing->user->name) ?></td>
                        <td><?= h($borrowing->quantity) ?></td>
                        <td><?= $borrowing->borrowed_date ? h($borrowing->borrowed_date->format('M d, Y')) : 'N/A' ?></td>
                        <td><?= $borrowing->return_date ? h($borrowing->return_date->format('M d, Y')) : 'N/A' ?></td>
                        <td><?= h($borrowing->status) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>