<?php

session_start();
require_once 'Database.php';

class Application {
    
    public static $subjects = [
        1 => 'Бизнес и коммуникации',
        2 => 'Технологии',
        3 => 'Реклама',
        4 => 'Маркетинг',
        5 => 'Проектирование',
    ];

    public static $payments = [
        1 => 'WebMoney',
        2 => 'Яндекс.Деньги',
        3 => 'PayPal',
        4 => 'Кредитная карта',
        5 => 'Робокасса',
    ];

    public $name;
    public $lastname;
    public $email;
    public $phone;
    public $theme;
    public $payment;
    public $mailing;
    
    public $errors = [];

    public function __construct($data = []) {
        if (!empty($data)) {
            $this->name = $data['name'] ?? '';
            $this->lastname = $data['lastname'] ?? '';
            $this->email = $data['email'] ?? '';
            $this->phone = $data['phone'] ?? '';
            $this->theme = (int)($data['theme'] ?? 0);
            $this->payment = (int)($data['payment'] ?? 0);
            $this->mailing = !empty($data['mailing']) ? 1 : 0;
        }
    }

    public function validate() {
        $this->errors = [];
        
        if (empty($this->name)) { $this->errors['name'] = 'Поле с именем обязательно!'; }
        if (empty($this->lastname)) { $this->errors['lastname'] = 'Поле с фамилией обязательно!'; }
        if (empty($this->email)) { $this->errors['email'] = 'Поле электронной почты обязательно!'; }
        if (empty($this->phone)) { $this->errors['phone'] = 'Поле с номером обязательно!'; }
        if (empty($this->theme) || !isset(self::$subjects[$this->theme])) { $this->errors['theme'] = 'Выберите тему конференции'; }
        if (empty($this->payment) || !isset(self::$payments[$this->payment])) { $this->errors['payment'] = 'Выберите способ оплаты'; }

        return empty($this->errors);
    }

    public function save() {
        $sql = 'INSERT INTO participants (name, lastname, email, tel, subject, payment, mailing, created_at, updated_at) 
                VALUES (:name, :lastname, :email, :phone, :theme, :payment, :mailing, NOW(), NOW())';

        Database::exec($sql, [
            'name' => $this->name,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'phone' => $this->phone,
            'theme' => $this->theme,
            'payment' => $this->payment,
            'mailing' => $this->mailing,
        ]);
    }
}

$succses = false;
$errors = [];

if (isset($_SESSION['success'])) {
    $succses = true;
    unset($_SESSION['success']);
}

if (!empty($_POST)) {
    $app = new Application($_POST);

    if ($app->validate()) {
        $app->save();
        $_SESSION['success'] = true;
        header('Location: ?'); 
        exit;
    } else {
        $errors = $app->errors;
    }
}
?>