<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #3A53A4; color: white; }
    </style>
</head>
<body>
    <h2>UAO-IMS Inventory Report</h2>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Category</th>
                <th>Condition</th>
                <th>Quantity</th>
                <th>Procurement Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($inventoryItems as $item): ?>
                <tr>
                    <td><?= h($item->name) ?></td>
                    <td><?= h(ucwords(str_replace('_', ' ', $item->category))) ?></td>
                    <td><?= h(ucwords($item->item_condition)) ?></td>
                    <td><?= h($item->quantity) ?></td>
                    <td><?= h($item->procurement_date) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
