<?php

$file = 'data/requests.txt';
$separator = '|';

function e($value) {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['delete'])) {
    if (file_exists($file)) {
        $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        foreach ($_POST['delete'] as $idx) {
            if (isset($lines[$idx])) {
                $cols = explode($separator, $lines[$idx]);
                $cols[0] = 'deleted';
                $lines[$idx] = implode($separator, $cols);
            }
        }
        
        file_put_contents($file, implode(PHP_EOL, $lines) . PHP_EOL, LOCK_EX);
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
}

$requests = [];
if (file_exists($file)) {
    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    foreach ($lines as $idx => $line) {
        $cols = explode($separator, $line);
        
        if (isset($cols[0]) && $cols[0] === 'active' && count($cols) >= 10) {
            [$status, $date, $ip, $name, $lname, $email, $phone, $topic, $pay, $mailing] = $cols;

            $content = "Дата: $date\n";
            $content .= "ФИО: $name $lname\n";
            $content .= "Email: $email\n";
            $content .= "Телефон: $phone\n";
            $content .= "Тема: $topic\n";
            $content .= "Оплата: $pay\n";
            $content .= "Рассылка: $mailing\n";
            $content .= "IP: $ip";

            $requests[$idx] = $content;
        }
    }
}