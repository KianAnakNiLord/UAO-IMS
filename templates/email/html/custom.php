<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .email-container {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            max-width: 600px;
            margin: auto;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .email-header {
            background-color: #3A53A4;
            color: #fff;
            padding: 12px;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
        }
        .email-content {
            padding: 20px;
            color: #333;
        }
        .email-footer {
            font-size: 12px;
            color: #888;
            margin-top: 20px;
            text-align: center;
        }
        .highlight {
            color: #B99433;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header"><?= $this->fetch('header') ?></div>
        <div class="email-content"><?= $this->fetch('content') ?></div>
        <div class="email-footer">UAO Inventory Team • Xavier University - Ateneo de Cagayan</div>
    </div>
</body>
</html>
