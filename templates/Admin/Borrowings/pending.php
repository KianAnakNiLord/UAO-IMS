<h1>Pending Borrow Requests</h1>

<table>
    <tr>
        <th>Borrower</th>
        <th>Item</th>
        <th>Borrowed Date</th>
        <th>Return Date</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($pending as $request): ?>
    <tr>
        <td><?= h($request->borrower->name) ?></td>
        <td><?= h($request->item->name) ?></td>
        <td><?= h($request->borrowed_date) ?></td>
        <td><?= h($request->return_date) ?></td>
        <td>
            <?= $this->Html->link('Approve', ['action' => 'approve', $request->id]) ?> |
            <?= $this->Html->link('Reject', ['action' => 'reject', $request->id]) ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
