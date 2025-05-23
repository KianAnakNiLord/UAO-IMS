<?= $this->Html->css('borrow_requests') ?>

<div class="borrow-requests-container">
    <h3>Borrow Requests Management</h3>

    <table class="borrow-requests-table">
        <thead>
            <tr>
                <th>Borrower</th>
                <th>Item</th>
                <th>Quantity</th>
                <th>Purpose</th>
                <th>Status</th>
                <th>Request Date</th>
                <th>Return Date</th>
                <th>Return Time</th>
                <th>ID Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($borrowRequests as $request): ?>
            <tr>
                <td><?= h($request->user->name ?? 'N/A') ?></td>
                <td><?= h($request->inventory_item->name ?? 'N/A') ?></td>
                <td><?= h($request->quantity_requested) ?></td>
                <td><?= h($request->purpose ?? '—') ?></td>

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

                <td><?= h($request->request_date) ?></td>
                <td><?= h($request->return_date) ?></td>
                <td><?= h($request->return_time ?? 'N/A') ?></td>

                <td>
                    <?php if (!empty($request->id_image)): ?>
                        <?php $imagePath = ltrim($request->id_image, '/\\'); ?>
                        <a href="<?= $this->Url->build('/' . $imagePath) ?>" target="_blank">
                            <img src="<?= $this->Url->build('/' . $imagePath) ?>" width="60" alt="ID Image" onerror="this.style.display='none'">
                        </a>
                    <?php else: ?>
                        <em>No ID</em>
                    <?php endif; ?>
                </td>

                <td>
                    <?php if ($request->status === 'pending'): ?>
                        <?= $this->Html->link('✅ Approve', ['action' => 'approveRequest', $request->id], ['class' => 'button']) ?>
                        <?= $this->Html->link('❌ Reject', ['action' => 'rejectForm', $request->id], ['class' => 'button danger']) ?>
                    <?php else: ?>
                        <em>—</em>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

