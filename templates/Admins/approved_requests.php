<?= $this->Html->css('approvedRequests') ?>

<div class="approved-requests-container">
    <h1>Approved Borrow Requests</h1>

    <table class="approved-requests-table">
        <thead>
            <tr>
                <th>Borrower</th>
                <th>Item</th>
                <th>Quantity</th>
                <th>Return Date</th>
                <th>Return Time</th>
                <th>ID Photo</th>
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
                <td><?= h($request->return_time) ?></td>
                <td>
                    <?php if (!empty($request->id_image)): ?>
                        <?php $imagePath = ltrim($request->id_image, '/\\'); ?>
                        <a href="<?= $this->Url->build('/' . $imagePath) ?>" target="_blank">
                            <img src="<?= $this->Url->build('/' . $imagePath) ?>" alt="ID Photo" style="max-width:100px; max-height:100px; border-radius: 6px; border: 1px solid #ccc;">
                        </a>
                    <?php else: ?>
                        <em>No image</em>
                    <?php endif; ?>
                </td>
                <td>
                    <div class="action-buttons">
                        <?= $this->Html->link('Mark as Returned', ['action' => 'markAsReturned', $request->id], ['class' => 'btn mark-returned']) ?>
                        <?php if ($request->status === 'overdue' && $request->return_date && $request->return_time): ?>
                            <?php
                                $due = new DateTime($request->return_date->format('Y-m-d') . ' ' . $request->return_time->format('H:i:s'));
                                $now = new DateTime();
                                $interval = $now->diff($due);
                                echo "<span class='overdue-text'>Overdue by {$interval->days} days, {$interval->h} hrs, {$interval->i} min</span>";
                            ?>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
