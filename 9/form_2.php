<?php

session_start();

class Application {
    
    public static function readAll() {
        $file = 'data/requests.txt';
        $requests = [];
        $separator = '|';
        
        if (file_exists($file)) {
            $content = file_get_contents($file);
            $lines = explode("\n", $content);
            
            foreach ($lines as $idx => $line) {
                $line = trim($line);
                if (empty($line)) continue;
                
                $cols = explode($separator, $line);
                
                if (isset($cols[0]) && $cols[0] === 'active') {
                    $date = $cols[1] ?? '';
                    $ip = $cols[2] ?? '';
                    $name = $cols[3] ?? '';
                    $lname = $cols[4] ?? '';
                    $email = $cols[5] ?? '';
                    $phone = $cols[6] ?? '';
                    $topic = $cols[7] ?? '';
                    $pay = $cols[8] ?? '';
                    $mailing = $cols[9] ?? '';
                    
                    $formatted = "Дата: $date\n";
                    $formatted .= "ФИО: $name $lname\n";
                    $formatted .= "Email: $email\n";
                    $formatted .= "Телефон: $phone\n";
                    $formatted .= "Тема: $topic\n";
                    $formatted .= "Оплата: $pay\n";
                    $formatted .= "Рассылка: $mailing\n";
                    $formatted .= "IP: $ip";
                    
                    $requests[$idx] = $formatted;
                }
            }
        }
        return $requests;
    }

    public static function delete($ids) {
        $file = 'data/requests.txt';
        $separator = '|';
        
        if (file_exists($file)) {
            $content = file_get_contents($file);
            $lines = explode("\n", $content);
            
            foreach ($ids as $idx) {
                if (isset($lines[$idx])) {
                    $cols = explode($separator, $lines[$idx]);
                    if (isset($cols[0])) {
                        $cols[0] = 'deleted';
                        $lines[$idx] = implode($separator, $cols);
                    }
                }
            }
            
            file_put_contents($file, implode("\n", $lines));
        }
    }
}

if (!empty($_POST['delete'])) {
    Application::delete($_POST['delete']);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

$requests = Application::readAll();
?>