<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= h($this->fetch('title') ?? 'UAO Inventory System') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Reset and base styles */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', 'Helvetica Neue', Arial, sans-serif;
            background-color: #f3f4f6;
            padding: 40px 16px;
            color: #333;
        }

        .email-wrapper {
            max-width: 680px;
            margin: auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.1);
            border: 1px solid #e1e4e8;
        }

        .email-header {
            background-color: #3A53A4;
            color: #fff;
            padding: 20px;
            text-align: center;
            position: relative;
        }

        .email-header img {
            max-height: 60px;
            margin-bottom: 10px;
        }

        .email-title {
            font-size: 22px;
            font-weight: bold;
        }

        .email-subheader {
            background-color: #B99433;
            color: #fff;
            padding: 10px;
            text-align: center;
            font-size: 14px;
            font-style: italic;
        }

        .email-body {
            padding: 32px 26px;
            font-size: 16px;
            line-height: 1.7;
            color: #2c2c2c;
        }

        .email-footer {
            background-color: #fafafa;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #777;
            border-top: 1px solid #ddd;
        }

        .highlight {
            color: #B99433;
            font-weight: bold;
        }

        .accent {
            color: #3A53A4;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .email-body {
                padding: 24px 18px;
                font-size: 15px;
            }

            .email-header {
                padding: 16px;
            }
        }
    </style>
</head>
<body>

    <div class="email-wrapper">
        <div class="email-header">
            <div class="email-title"><?= $this->fetch('header') ?: 'University Athletics Office Notification' ?></div>
        </div>

        <div class="email-subheader">
            Xavier University - Ateneo de Cagayan • University Athletics Office
        </div>

        <div class="email-body">
            <?= $this->fetch('content') ?>
        </div>

        <div class="email-footer">
            &copy; <?= date('Y') ?> University Athletics Office. All rights reserved.<br>
            This is an automated message. Please do not reply to this email.
        </div>
    </div>

</body>
</html>
