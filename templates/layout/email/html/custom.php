<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= h($this->fetch('title') ?? 'UAO Inventory System') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Base Reset */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', 'Helvetica Neue', Arial, sans-serif;
            background-color: #f5f7fa;
            padding: 30px 15px;
            color: #333;
        }

        .email-wrapper {
            max-width: 640px;
            margin: auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 6px 24px rgba(0,0,0,0.12);
            border: 1px solid #e0e0e0;
        }

        .email-header {
            background-color: #3A53A4;
            color: #ffffff;
            padding: 24px;
            font-size: 22px;
            font-weight: bold;
            text-align: center;
        }

        .email-subheader {
            background-color: #B99433;
            color: #ffffff;
            text-align: center;
            padding: 10px;
            font-size: 14px;
            font-style: italic;
        }

        .email-body {
            padding: 30px 24px;
            font-size: 16px;
            line-height: 1.6;
            color: #333333;
        }

        .email-body strong {
            color: #3A53A4;
        }

        .email-footer {
            background-color: #fafafa;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #999999;
            border-top: 1px solid #ddd;
        }

        .button {
            display: inline-block;
            background-color: #3A53A4;
            color: #ffffff !important;
            padding: 12px 24px;
            margin-top: 20px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
        }

        .note {
            background-color: #fef9e7;
            border-left: 4px solid #B99433;
            padding: 12px 16px;
            margin-top: 20px;
            font-size: 14px;
            color: #5c5c5c;
        }

        @media only screen and (max-width: 600px) {
            .email-body {
                padding: 20px 16px;
                font-size: 15px;
            }

            .email-header {
                font-size: 20px;
                padding: 20px;
            }
        }
    </style>
</head>
<body>

    <div class="email-wrapper">
        <div class="email-header">
            <?= $this->fetch('header') ?: 'UAO Inventory Notification' ?>
        </div>

        <div class="email-subheader">
            Xavier University - Ateneo de Cagayan • University Athletics Office
        </div>

        <div class="email-body">
            <?= $this->fetch('content') ?>
        </div>

        <div class="email-footer">
            &copy; <?= date('Y') ?> University Athletics Office — All rights reserved.<br>
            This is an automated message. Please do not reply to this email.
        </div>
    </div>

</body>
</html>
