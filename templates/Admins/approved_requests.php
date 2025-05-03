<?= $this->Html->css('approvedRequests') ?>

<h1>Approved Borrow Requests</h1>

<!-- Approved Requests Table -->
<table>
    <thead>
        <tr>
            <th>Borrower</th>
            <th>Item</th>
            <th>Quantity</th>
            <th>Return Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($approvedRequests as $request): ?>
        <tr>
            <td><?= h($request->user->name) ?></td>
            <td><?= h($request->inventory_item->name) ?></td>
            <td><?= h($request->quantity_requested) ?></td>
            <td><?= h($request->return_date) ?></td>
            <td>
                <?= $this->Html->link('Mark as Returned', ['action' => 'markAsReturned', $request->id], ['class' => 'btn mark-returned']) ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
