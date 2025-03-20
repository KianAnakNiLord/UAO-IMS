<?= $this->Html->css('cake.default') ?> <!-- Optional: Default CakePHP styling -->

<h1>Borrowings List</h1>

<!-- Search Form -->
<?= $this->Form->create(null, ['type' => 'get']) ?>
    <?= $this->Form->control('search', ['label' => 'Search by Borrower Name', 'value' => $this->request->getQuery('search')]) ?>
    <?= $this->Form->button('Search') ?>
<?= $this->Form->end() ?>

<!-- Borrowings Table -->
<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Borrower</th>
            <th>Item</th>
            <th>Borrowed Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($borrowings as $borrowing): ?>
            <tr>
                <td><?= h($borrowing->id) ?></td>
                <td><?= h($borrowing->borrower->name) ?></td>
                <td><?= h($borrowing->item->name) ?></td>
                <td><?= h($borrowing->created) ?></td>
                <td>
                    <?= $this->Html->link('View', ['action' => 'view', $borrowing->id]) ?> |
                    <?= $this->Html->link('Edit', ['action' => 'edit', $borrowing->id]) ?> |
                    <?= $this->Form->postLink('Delete', ['action' => 'delete', $borrowing->id], ['confirm' => 'Are you sure?']) ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Pagination -->
<div>
    <?= $this->Paginator->prev('« Previous') ?>
    <?= $this->Paginator->numbers() ?>
    <?= $this->Paginator->next('Next »') ?>
</div>

<p>
    <?= $this->Html->link('Borrow Equipment', ['controller' => 'Borrowings', 'action' => 'add'], ['class' => 'button']) ?>
</p>
<?= $this->Html->link('Add Borrower', 
    ['controller' => 'Borrowings', 'action' => 'addborrower'], 
    ['class' => 'button', 'style' => 'padding:10px; background-color:#28a745; color:white; text-decoration:none; border-radius:5px;']
) ?>

