<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Таблица умножения</title>
    <style>
        body {
            font-family: sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 95vh;
        }
        table {
            border-collapse: collapse;
            width: 50%;
            margin: 20px auto;
            text-align: center;
        }
        td {
            padding: 5px;
            border: 1px solid black;
            font-size: 14pt;
        }
        td:first-child {
            background-color: #fecb99;
            font-weight: bold;
            border: 2px solid #800000;
        }
        tr:first-child td {
            background-color: #fecb99;
            font-weight: bold;
            border: 2px solid #800000;
        }
        tr:first-child td:first-child {
            background-color: #800000;
        }
        .diagonal {
            background-color: #fdfe98;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <?php require_once 'table.php'; ?>
</body>
</html>