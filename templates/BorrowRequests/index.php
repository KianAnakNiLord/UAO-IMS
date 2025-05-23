<?= $this->Html->css('borrow_requests_index') ?>

<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\BorrowRequest> $borrowRequests
 */
?>
<div class="borrowRequests index content">
    <?= $this->Html->link(__('New Borrow Request'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Borrow Requests') ?></h3>

    <!-- 🔽 Enhanced Status Filter Bar -->
<div class="filter-section">
    <label for="statusFilter">Filter by Status:</label>
    <select id="statusFilter" class="form-control status-dropdown">
        <option value="">All</option>
        <option value="approved">Approved</option>
        <option value="pending">Pending</option>
        <option value="rejected">Rejected</option>
        <option value="returned">Returned</option>
        <option value="overdue">Overdue</option>
    </select>
</div>


    <div class="table-responsive">
        <table id="borrowRequestsTable">
            <thead>
                <tr>
                    <th><?= __('Inventory Item') ?></th>
                    <th><?= __('Quantity') ?></th>
                    <th><?= __('Status') ?></th>
                    <th><?= __('Request Date') ?></th>
                    <th><?= __('Return Date') ?></th>
                    <th><?= __('Return Time') ?></th>
                    <th><?= __('Created') ?></th>
                    <th><?= __('ID Image') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($borrowRequests as $borrowRequest): ?>
                <tr>
                    <td><?= h($borrowRequest->inventory_item->name) ?></td>
                    <td><?= h($borrowRequest->quantity_requested) ?> pcs</td>
                    <td class="status-cell">
    <?php
        $status = $borrowRequest->status;
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

    <?php if ($status === 'approved' && $borrowRequest->approval_note): ?>
    <br>
    <?= $this->Html->link('View Approval', ['action' => 'viewApproval', $borrowRequest->id], ['class' => 'view-reason-link']) ?>
<?php endif; ?>



    <?php if ($status === 'rejected' && $borrowRequest->rejection_reason): ?>
        <br>
        <?= $this->Html->link('View Reason', ['action' => 'viewReason', $borrowRequest->id], ['class' => 'view-reason-link']) ?>
    <?php endif; ?>

    <?php if ($status === 'overdue' && $borrowRequest->return_date && $borrowRequest->return_time): ?>
        <?php
            $due = new DateTime($borrowRequest->return_date->format('Y-m-d') . ' ' . $borrowRequest->return_time->format('H:i:s'));
            $now = new DateTime();
            $interval = $now->diff($due);
            echo "<br><small style='color:red;'>Overdue by {$interval->days}d {$interval->h}h {$interval->i}m</small>";
        ?>
    <?php endif; ?>
</td>

                    <td><?= h($borrowRequest->request_date) ?></td>
                    <td><?= h($borrowRequest->return_date) ?></td>
                    <td><?= h($borrowRequest->return_time ?? 'N/A') ?></td>
                    <td><?= h($borrowRequest->created) ?></td>

                    <td>
                        <?php
                            $user = $this->request->getAttribute('identity');
                            $isAdmin = $user && $user->get('role') === 'admin';
                            $isOwner = $user && $user->get('id') === $borrowRequest->user_id;
                        ?>

                        <?php if (!empty($borrowRequest->id_image) && ($isAdmin || $isOwner)): ?>
                            <?php $idImagePath = ltrim($borrowRequest->id_image, '/\\'); ?>
                            <a href="<?= $this->Url->build('/' . $idImagePath) ?>" target="_blank">
                                <img src="<?= $this->Url->build('/' . $idImagePath) ?>" width="60" alt="ID Image" onerror="this.style.display='none'">
                            </a>
                        <?php elseif (!$isAdmin && !$isOwner): ?>
                            <em>Private</em>
                        <?php else: ?>
                            <em>No ID</em>
                        <?php endif; ?>
                    </td>

                    <td class="actions">
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $borrowRequest->id],
                            [
                                'confirm' => __('Are you sure you want to delete # {0}?', $borrowRequest->id),
                                'class' => 'danger-btn',
                                'title' => 'Delete this request'
                            ]
                        ) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>

<!-- 🔍 JavaScript for Filtering -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const statusFilter = document.getElementById('statusFilter');
        const rows = document.querySelectorAll('#borrowRequestsTable tbody tr');

        statusFilter.addEventListener('change', function () {
            const selectedStatus = this.value.toLowerCase();

            rows.forEach(row => {
                const statusCell = row.querySelector('.status-cell');
                if (!statusCell) return;

                const text = statusCell.textContent.toLowerCase();
                const match = selectedStatus === '' || text.includes(selectedStatus);
                row.style.display = match ? '' : 'none';
            });
        });
    });
</script>
