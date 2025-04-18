<?= $this->Html->css('borrow_requests') ?>

<h3>Borrow Requests Management</h3>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Borrower</th>
            <th>Item</th>
            <th>Quantity</th>
            <th>Purpose</th> <!-- ✅ Correct header position -->
            <th>Status</th>
            <th>Request Date</th>
            <th>Return Date</th>
            <th>Rejection Reason</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($borrowRequests as $request): ?>
        <tr>
            <td><?= h($request->id) ?></td>
            <td><?= h($request->user->name ?? 'N/A') ?></td>
            <td><?= h($request->inventory_item->name ?? 'N/A') ?></td>
            <td><?= h($request->quantity_requested) ?></td>
            <td><?= h($request->purpose ?? '—') ?></td> <!-- ✅ Purpose now correctly displayed -->
            <td><?= ucfirst(h($request->status)) ?></td>
            <td><?= h($request->request_date) ?></td>
            <td><?= h($request->return_date) ?></td>
            <td>
                <?= $request->status === 'rejected' && $request->rejection_reason
                    ? h($request->rejection_reason)
                    : '—' ?>
            </td>
            <td>
                <?php if ($request->status === 'pending'): ?>
                    <?= $this->Html->link('✅ Approve', ['action' => 'approveRequest', $request->id], ['class' => 'button']) ?>
                    <?= $this->Html->link('❌ Reject', ['action' => 'rejectForm', $request->id], ['class' => 'button']) ?>
                <?php else: ?>
                    <em>—</em>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
