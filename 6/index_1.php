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

    <?php if (!empty($succses)): ?>
        <h2 style="color: green">Ваша заявка успешно принята!</h2>
    
    <?php else: ?>
    
        <?php if (!empty($errors)): ?>
            <h3 style="color: red">Проверьте правильность заполненности формы!</h3>
        <?php endif ?>      

        <form action="" method="POST">
            <div style="margin-bottom: 10px;">
                <label>Имя участника:</label>
                <br>
                <input type="text" name="name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
                <div style="color: red"><?= $errors['name'] ?? '' ?></div>
            </div>

            <div style="margin-bottom: 10px;">
                <label>Фамилия участника:</label>
                <br>
                <input type="text" name="lastname" value="<?= htmlspecialchars($_POST['lastname'] ?? '') ?>">
                <div style="color: red"><?= $errors['lastname'] ?? '' ?></div>
            </div>

            <div style="margin-bottom: 10px;">
                <label>Электронный адрес (Email):</label>
                <br>
                <input type="text" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                <div style="color: red"><?= $errors['email'] ?? '' ?></div>
            </div>

            <div style="margin-bottom: 10px;">
                <label>Телефон для связи:</label>
                <br>
                <input type="text" name="phone" value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">
                <div style="color: red"><?= $errors['phone'] ?? '' ?></div>
            </div>

            <div style="margin-bottom: 10px;">
                <label>Интересующая тематика конференции:</label>
                <br>
                <select name="topic">
                    <option value="">Выберите тематику</option>
                    <option value="Бизнес" <?= (isset($_POST['topic']) && $_POST['topic'] === 'Бизнес') ? 'selected' : '' ?>>Бизнес</option>
                    <option value="Технологии" <?= (isset($_POST['topic']) && $_POST['topic'] === 'Технологии') ? 'selected' : '' ?>>Технологии</option>
                    <option value="Реклама и Маркетинг" <?= (isset($_POST['topic']) && $_POST['topic'] === 'Реклама и Маркетинг') ? 'selected' : '' ?>>Реклама и Маркетинг</option>
                </select>
                <div style="color: red"><?= $errors['topic'] ?? '' ?></div>
            </div>

            <div style="margin-bottom: 10px;">
                <label>Предпочитаемый метод оплаты участия:</label>
                <br>
                <label>
                    <input type="radio" name="payment" value="WebMoney" <?= (isset($_POST['payment']) && $_POST['payment'] === 'WebMoney') ? 'checked' : '' ?>> WebMoney
                </label><br>
                <label>
                    <input type="radio" name="payment" value="Яндекс.Деньги" <?= (isset($_POST['payment']) && $_POST['payment'] === 'Яндекс.Деньги') ? 'checked' : '' ?>> Яндекс.Деньги
                </label><br>
                <label>
                    <input type="radio" name="payment" value="PayPal" <?= (isset($_POST['payment']) && $_POST['payment'] === 'PayPal') ? 'checked' : '' ?>> PayPal
                </label><br>
                <label>
                    <input type="radio" name="payment" value="Кредитная карта" <?= (isset($_POST['payment']) && $_POST['payment'] === 'Кредитная карта') ? 'checked' : '' ?>> Кредитная карта
                </label>
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