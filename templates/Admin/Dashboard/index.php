<h1>Pending Borrow Requests</h1>

<?php if ($pending->isEmpty()): ?>
    <p>No pending requests.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Borrower</th>
                <th>Item</th>
                <th>Borrowed Date</th>
                <th>Return Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($pending as $request): ?>
            <tr>
                <td><?= h($request->borrower_id) ?></td>
                <td><?= h($request->item_id) ?></td>
                <td><?= h($request->borrowed_date) ?></td>
                <td><?= h($request->return_date) ?></td>
                <td><?= h($request->status) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
