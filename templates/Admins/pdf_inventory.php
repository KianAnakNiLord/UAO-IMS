<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>UAO-IMS Inventory Report</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            font-size: 13px;
            margin: 40px 50px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
        }

        .logo {
            width: 80px;
            height: auto;
            margin-bottom: 10px;
        }

        h2 {
            color: #3A53A4;
            font-size: 20px;
            margin-bottom: 5px;
        }

        .subheader {
            font-size: 12px;
            color: #777;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px 12px;
            vertical-align: top;
            text-align: left;
        }

        th {
            background-color: #3A53A4;
            color: #fff;
            font-weight: 600;
            font-size: 13px;
        }

        td {
            font-size: 12px;
        }

        .footer {
            margin-top: 40px;
            font-size: 11px;
            text-align: right;
            color: #888;
        }

        .gold {
            color: #B99433;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="<?= WWW_ROOT ?>img/cruslogo.png" class="logo" alt="UAO Logo">
        <h2>University Athletics Office <span class="gold">– Inventory Report</span></h2>
        <div class="subheader">Generated by UAO-IMS on <?= date('F j, Y') ?></div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Category</th>
                <th>Condition</th>
                <th>Quantity</th>
                <th>Location</th>
                <th>Procurement Date</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($inventoryItems as $item): ?>
                <tr>
                    <td><?= h($item->name) ?></td>
                    <td><?= h(ucwords(str_replace('_', ' ', $item->category))) ?></td>
                    <td><?= h(ucwords($item->item_condition)) ?></td>
                    <td><?= h($item->quantity) ?></td>
                    <td><?= h($item->location) ?></td>
                    <td><?= h(date('F j, Y', strtotime((string)$item->procurement_date))) ?></td>
                    <td><?= h($item->description ?: '-') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="footer">
        Report generated on <?= date('F j, Y \a\t g:i A') ?>
    </div>
</body>
</html>
