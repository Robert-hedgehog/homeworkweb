<?php
session_start();

require_once 'database/Database.php';
require_once 'models/Task.php';

$route = $_GET['route'] ?? 'home';

if ($route === 'login') {
    require_once 'controllers/AuthController.php';
} 
elseif ($route === 'logout') {
    session_destroy();
    header('Location: index.php?route=login');
    exit;
} 
else {
    require_once 'controllers/TaskController.php';
}