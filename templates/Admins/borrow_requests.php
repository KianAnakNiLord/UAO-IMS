<?= $this->Html->css('borrow_requests') ?>

<h3>Borrow Requests Management</h3>

<table>
    <thead>
        <tr>
            <!-- Remove the ID column -->
            <th>Borrower</th>
            <th>Item</th>
            <th>Quantity</th>
            <th>Purpose</th> <!-- ✅ Correct header position -->
            <th>Status</th> <!-- Color-coded status -->
            <th>Request Date</th>
            <th>Return Date</th>
            <th>Return Time</th> <!-- Added Return Time column -->
            <th>Rejection Reason</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($borrowRequests as $request): ?>
        <tr>
            <!-- Borrower -->
            <td><?= h($request->user->name ?? 'N/A') ?></td>
            <!-- Item -->
            <td><?= h($request->inventory_item->name ?? 'N/A') ?></td>
            <!-- Quantity -->
            <td><?= h($request->quantity_requested) ?></td>
            <!-- Purpose -->
            <td><?= h($request->purpose ?? '—') ?></td> <!-- ✅ Purpose now correctly displayed -->
            
            <!-- Status with color coding -->
            <td>
                <?php
                    $status = $request->status;
                    $color = match ($status) {
                        'approved' => 'green',
                        'pending' => 'orange',
                        'rejected' => 'red',
                        'returned' => 'blue',
                        'overdue' => 'darkred',
                        default => 'black'
                    };
                ?>
                <span style="color: <?= $color ?>;">
                    <?= ucfirst(h($status)) ?>
                </span>
            </td>
            
            <!-- Request Date -->
            <td><?= h($request->request_date) ?></td>
            <!-- Return Date -->
            <td><?= h($request->return_date) ?></td>
            <!-- Return Time -->
            <td><?= h($request->return_time ?? 'N/A') ?></td> <!-- ✅ Added Return Time column -->
            <!-- Rejection Reason -->
            <td>
                <?= $request->status === 'rejected' && $request->rejection_reason
                    ? h($request->rejection_reason)
                    : '—' ?>
            </td>
            <!-- Actions -->
            <td>
    <?php if ($request->status === 'pending'): ?>
        <?= $this->Html->link('✅ Approve', ['action' => 'approveRequest', $request->id], ['class' => 'button approve']) ?>
        <?= $this->Html->link('❌ Reject', ['action' => 'rejectForm', $request->id], ['class' => 'button reject']) ?>
    <?php else: ?>
        <em>—</em>
    <?php endif; ?>
</td>

        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
