<?php require_once 'form_2.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Админ-панель: Заявки</title>
</head>
<body>

    <h1>Оставленные заявки на конференцию</h1>

    <?php if (empty($applications)): ?>
        <p style="color: gray;">На данный момент заявок нет</p>
    <?php else: ?>
        
        <form action="" method="POST">
            
            <?php foreach ($applications as $filename => $content): ?>
                <div style="border: 1px solid; padding: 15px; margin-bottom: 15px; border-radius: 5px">
                    <label style="cursor: pointer; display: block; margin-bottom: 10px;">
                        <input type="checkbox" name="delete[]" value="<?= htmlspecialchars($filename) ?>">
                        <b>Удалить эту заявку</b>
                        <span style="font-size: 12px; color: gray;">(Файл: <?= htmlspecialchars($filename) ?>)</span>
                    </label>
                    
                    <hr>
                    
                    <pre style="font-family: inherit; margin: 0;"><?= htmlspecialchars($content) ?></pre>
                </div>
            <?php endforeach; ?>

            <div style="position: sticky; bottom: 20px; background: white; padding: 10px; border: 1px">
                <button type="submit" style="background: red; color: white; border: none; padding: 10px 20px; cursor: pointer; border-radius: 3px;">
                    Удалить выбранные
                </button>
            </div>
            
        </form>

    <?php endif ?>

</body>
</html>