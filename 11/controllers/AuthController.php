<?php
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$errors = [];
$success_msg = '';

if (!empty($_POST)) {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $errors[] = 'Заполните все поля!';
    }

    if (empty($errors)) {
        if (isset($_POST['action_register'])) {
            $stmt = Database::query("SELECT id FROM users WHERE username = :username LIMIT 1", ['username' => $username]);
            if ($stmt->fetch()) {
                $errors[] = 'Пользователь с таким именем уже существует!';
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                Database::exec("INSERT INTO users (username, password_hash) VALUES (:username, :hash)", [
                    'username' => $username,
                    'hash' => $hash
                ]);
                $success_msg = 'Регистрация прошла успешно! Теперь вы можете войти.';
            }
        } elseif (isset($_POST['action_login'])) {
            $stmt = Database::query("SELECT * FROM users WHERE username = :username LIMIT 1", ['username' => $username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password_hash'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header('Location: index.php');
                exit;
            } else {
                $errors[] = 'Неверное имя пользователя или пароль!';
            }
        }
    }
}

require_once 'views/login_view.php';