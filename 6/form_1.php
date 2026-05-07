<?php

    // logic

    if (!empty($_GET['success'])) {
        if ($_GET['success'] >= time()) {
            $succses = true;
        } else {
            header('Location: ?'); 
            exit;
        }
    }

    if (count($_POST)) {

        // validation

        $errors = [];
        if (empty($_POST['name'])) {
            $errors['name'] = 'Поле с именем обязательно к заполнению!';
        }

        if (empty($_POST['lastname'])) {
            $errors['lastname'] = 'Поле с фамилией обязательно к заполнению!';
        }

        if (empty($_POST['email'])) {
            $errors['email'] = 'Поле с email обязательно к заполнению!';
        }

        if (empty($_POST['phone'])) {
            $errors['phone'] = 'Поле с телефоном обязательно к заполнению!';
        }

        if (empty($_POST['topic'])) {
            $errors['topic'] = 'Выберите тематику конференции!';
        }

        if (empty($_POST['payment'])) {
            $errors['payment'] = 'Выберите метод оплаты!';
        }

        if (!$errors) {
            $dir = 'data/';

            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }

            $file = $dir . 'requests.txt';
            $separator = '|';

            $status = 'active';
            $date = date('d.m.Y H:i:s');
            $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
            $mailing = !empty($_POST['mailing']) ? 'Да' : 'Нет';

            $formData = [
                $status,
                $date,
                $ip,
                $_POST['name'],
                $_POST['lastname'],
                $_POST['email'],
                $_POST['phone'],
                $_POST['topic'],
                $_POST['payment'],
                $mailing
            ];

            foreach ($formData as &$field) {
                $field = str_replace($separator, '', (string)$field);
            }
            unset($field);
            $row = implode($separator, $formData) . PHP_EOL;
            file_put_contents($file, $row, FILE_APPEND | LOCK_EX);

            header('Location: ?success=' . (time() + 10));
            exit;
        }

    }

?>