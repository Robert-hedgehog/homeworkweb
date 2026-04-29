<?php

    if (!empty($_POST['delete'])) {
        
        foreach ($_POST['delete'] as $filename) {
            if (is_file($filename)) {
                unlink($filename);
            }
        }

        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }

    $applications = [];
    $dir = 'data/';
    
    if (is_dir($dir)) {
        foreach (glob($dir . '*.txt') as $filename) {
            $applications[$filename] = file_get_contents($filename);
        }
    }

?>