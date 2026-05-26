<?php

session_start();

class Application {
    public $name;
    public $lastname;
    public $email;
    public $phone;
    public $topic;
    public $payment;
    public $mailing;
    public $ip;
    public $date;
    public $status;
    
    public $errors = [];

    public function __construct($data = []) {
        if (!empty($data)) {
            $this->name = $data['name'] ?? '';
            $this->lastname = $data['lastname'] ?? '';
            $this->email = $data['email'] ?? '';
            $this->phone = $data['phone'] ?? '';
            $this->topic = $data['topic'] ?? '';
            $this->payment = $data['payment'] ?? '';
            $this->mailing = !empty($data['mailing']) ? 'Да' : 'Нет';
            $this->ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
            $this->date = date('d.m.Y H:i:s');
            $this->status = 'active';
        }
    }

    public function validate() {
        $this->errors = [];
        
        if (empty($this->name)) { $this->errors['name'] = 'Поле с именем обязательно к заполнению!'; }
        if (empty($this->lastname)) { $this->errors['lastname'] = 'Поле с фамилией обязательно к заполнению!'; }
        if (empty($this->email)) { $this->errors['email'] = 'Поле с email обязательно к заполнению!'; }
        if (empty($this->phone)) { $this->errors['phone'] = 'Поле с телефоном обязательно к заполнению!'; }
        if (empty($this->topic)) { $this->errors['topic'] = 'Выберите тематику конференции!'; }
        if (empty($this->payment)) { $this->errors['payment'] = 'Выберите метод оплаты!'; }

        return empty($this->errors);
    }

    public function save() {
        $dir = 'data/';
        if (!is_dir($dir)) {
            mkdir($dir);
        }
        $file = $dir . 'requests.txt';
        $separator = '|';

        $name = str_replace($separator, '', $this->name);
        $lastname = str_replace($separator, '', $this->lastname);
        $email = str_replace($separator, '', $this->email);
        $phone = str_replace($separator, '', $this->phone);
        $topic = str_replace($separator, '', $this->topic);
        $payment = str_replace($separator, '', $this->payment);

        $row = $this->status . $separator . $this->date . $separator . $this->ip . $separator . $name . $separator . $lastname . $separator . $email . $separator . $phone . $separator . $topic . $separator . $payment . $separator . $this->mailing;
        
        $content = "";
        if (file_exists($file)) {
            $content = file_get_contents($file);
        }
        $content .= $row . "\n";
        
        file_put_contents($file, $content);
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