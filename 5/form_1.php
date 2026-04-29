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

        // handle
        if (!$errors) {
            $dir = 'data/';

            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }

            $filename = $dir . 'data-' . date('Y-m-d-H-i-s') . '-' . rand(100, 999) . '.txt';

            $contents = 'Дата и время заявки: ' . date('d.m.Y H:i:s') . "\n";
            $contents .= 'Имя: ' . $_POST['name'] . "\n";
            $contents .= 'Фамилия: ' . $_POST['lastname'] . "\n";
            $contents .= 'Email: ' . $_POST['email'] . "\n";
            $contents .= 'Телефон: ' . $_POST['phone'] . "\n";
            $contents .= 'Тематика: ' . $_POST['topic'] . "\n";
            $contents .= 'Метод оплаты: ' . $_POST['payment'] . "\n";
            $contents .= 'Рассылка: ' . (!empty($_POST['mailing']) ? 'Да' : 'Нет') . "\n";

            file_put_contents($filename, $contents);

            header('Location: ?success=' . (time() + 10));
            exit;
        }

    }

?>