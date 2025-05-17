<?= $this->Html->css('approvedRequests') ?>

<h1>Approved Borrow Requests</h1>

<table>
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
                        <img src="<?= $this->Url->build('/' . $imagePath) ?>" alt="ID Photo" style="max-width:100px; max-height:100px;">
                    </a>
                <?php else: ?>
                    <span>No image</span>
                <?php endif; ?>
            </td>
            <td>
                <div class="action-buttons">
                    <?= $this->Html->link('Mark as Returned', ['action' => 'markAsReturned', $request->id], ['class' => 'btn mark-returned']) ?>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
