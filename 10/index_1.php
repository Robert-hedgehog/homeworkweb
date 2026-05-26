<?php require_once 'form_1.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Заявка на конференцию</title>
</head>
<body>
    <h1>Форма регистрации на конференцию</h1>

    <?php if ($succses): ?>
        <h2 style="color: green">Ваша заявка успешно принята!</h2>
    <?php else: ?>
        <?php if (!empty($errors)): ?>
            <h3 style="color: red">Проверьте правильность заполненности формы!</h3>
        <?php endif ?>      

        <form action="" method="POST">
            <div style="margin-bottom: 10px;">
                <label>Имя участника:</label><br>
                <input type="text" name="name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
                <div style="color: red"><?= $errors['name'] ?? '' ?></div>
            </div>

            <div style="margin-bottom: 10px;">
                <label>Фамилия участника:</label><br>
                <input type="text" name="lastname" value="<?= htmlspecialchars($_POST['lastname'] ?? '') ?>">
                <div style="color: red"><?= $errors['lastname'] ?? '' ?></div>
            </div>

            <div style="margin-bottom: 10px;">
                <label>Электронный адрес (Email):</label><br>
                <input type="text" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                <div style="color: red"><?= $errors['email'] ?? '' ?></div>
            </div>

            <div style="margin-bottom: 10px;">
                <label>Телефон для связи:</label><br>
                <input type="text" name="phone" value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">
                <div style="color: red"><?= $errors['phone'] ?? '' ?></div>
            </div>

            <div style="margin-bottom: 10px;">
                <label>Интересующая тематика конференции:</label><br>
                <select name="theme">
                    <option value="0">Выберите тематику</option>
                    <?php foreach (Application::$subjects as $id => $title): ?>
                        <option value="<?= $id ?>" <?= (isset($_POST['theme']) && (int)$_POST['theme'] === $id) ? 'selected' : '' ?>>
                            <?= $title ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div style="color: red"><?= $errors['theme'] ?? '' ?></div>
            </div>

            <div style="margin-bottom: 10px;">
                <label>Предпочитаемый метод оплаты участия:</label><br>
                <?php foreach (Application::$payments as $id => $title): ?>
                    <label>
                        <input type="radio" name="payment" value="<?= $id ?>" <?= (isset($_POST['payment']) && (int)$_POST['payment'] === $id) ? 'checked' : '' ?>> 
                        <?= $title ?>
                    </label><br>
                <?php endforeach; ?>
                <div style="color: red"><?= $errors['payment'] ?? '' ?></div>
            </div>

            <div style="margin-bottom: 15px;">
                <label>
                    <input type="checkbox" name="mailing" value="yes" <?= !empty($_POST['mailing']) ? 'checked' : '' ?>>
                    Желаю получать рассылку о конференции
                </label>
            </div>

            <div>
                <button type="submit">Отправить заявку</button>
            </div>
        </form>
    <?php endif ?>
</body>
</html>