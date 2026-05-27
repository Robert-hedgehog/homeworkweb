<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Авторизация</title>
    <style>
        body { font-family: sans-serif; max-width: 400px; margin: 100px auto; padding: 20px; }
        .frame { border: 2px solid #000; padding: 20px; position: relative; }
        .frame-title { font-weight: bold; position: absolute; top: -12px; left: 15px; background: #fff; padding: 0 10px; }
        .form-group { margin-bottom: 15px; display: flex; flex-direction: column; }
        .form-group label { font-weight: bold; margin-bottom: 5px; }
        .form-group input { padding: 6px; border: 2px solid #000; font-family: inherit; }
        .btn-group { display: flex; gap: 10px; margin-top: 15px; }
        .btn-sketch { border: 2px solid #000; background: #fff; padding: 6px 15px; font-weight: bold; cursor: pointer; }
        .btn-sketch:active { transform: translate(1px, 1px); box-shadow: 1px 1px 0px #000; }
        .error { color: red; font-size: 13px; margin-bottom: 15px; }
        .success { color: green; font-size: 13px; margin-bottom: 15px; }
    </style>
</head>
<body>

    <div class="frame">
        <span class="frame-title">Вход в календарь</span>
        
        <?php foreach ($errors as $error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endforeach; ?>

        <?php if ($success_msg): ?>
            <div class="success"><?= htmlspecialchars($success_msg) ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group">
                <label>Имя пользователя:</label>
                <input type="text" name="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>Пароль:</label>
                <input type="password" name="password">
            </div>

            <div class="btn-group">
                <button type="submit" name="action_login" value="1" class="btn-sketch">Войти</button>
                <button type="submit" name="action_register" value="1" class="btn-sketch" style="background: #f0f0f0;">Регистрация</button>
            </div>
        </form>
    </div>

</body>
</html>