<?php

session_start();
require_once 'Database.php';

class Application {
    
    public static $subjects = [
        1 => 'Бизнес и коммуникации', 2 => 'Технологии', 3 => 'Реклама', 4 => 'Маркетинг', 5 => 'Проектирование'
    ];

    public static $payments = [
        1 => 'WebMoney', 2 => 'Яндекс.Деньги', 3 => 'PayPal', 4 => 'Кредитная карта', 5 => 'Робокасса'
    ];

    public $id;
    public $name;
    public $lastname;
    public $email;
    public $tel;
    public $subject;
    public $payment;
    public $mailing;
    public $created_at;
    public $updated_at;
    public $deleted_at;

    public static function readAll() {
        $sqlQuery = Database::query('SELECT * FROM participants WHERE deleted_at IS NULL ORDER BY created_at DESC');
        $requests = [];

        while ($app = $sqlQuery->fetchObject(static::class)) {
            $date = date('d.m.Y H:i:s', strtotime($app->created_at));
            $themeStr = self::$subjects[$app->subject] ?? 'Неизвестно';
            $paymentStr = self::$payments[$app->payment] ?? 'Неизвестно';
            $mailingStr = $app->mailing ? 'Да' : 'Нет';

            $content = "Дата: $date\n";
            $content .= "ФИО: {$app->name} {$app->lastname}\n";
            $content .= "Email: {$app->email}\n";
            $content .= "Телефон: {$app->tel}\n";
            $content .= "Тема: $themeStr\n";
            $content .= "Оплата: $paymentStr\n";
            $content .= "Рассылка: $mailingStr";

            $requests[$app->id] = $content;
        }
        
        return $requests;
    }

    public static function deleteByIds(array $ids) {
        foreach ($ids as $id) {
            Database::exec('UPDATE participants SET deleted_at = NOW() WHERE id = :id LIMIT 1', ['id' => $id]);
        }
    }
}

if (!empty($_POST['delete'])) {
    Application::deleteByIds($_POST['delete']);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

$requests = Application::readAll();
?>