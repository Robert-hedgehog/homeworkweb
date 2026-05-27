<?php

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?route=login');
    exit;
}

$success = false;
$errors = [];
$editMode = false;
$taskToEdit = null;

if (isset($_SESSION['success'])) {
    $success = true;
    unset($_SESSION['success']);
}

if (isset($_GET['edit'])) {
    $taskToEdit = Task::find((int)$_GET['edit']);
    if ($taskToEdit) {
        $editMode = true;
    }
}

if (!empty($_POST)) {
    if (isset($_POST['action_delete']) && $editMode) {
        Database::exec("DELETE FROM tasks WHERE id = :id AND user_id = :user_id LIMIT 1", [
            'id' => $taskToEdit->id,
            'user_id' => $_SESSION['user_id']
        ]);
        header('Location: index.php');
        exit;
    } 
    elseif (isset($_POST['action_complete']) && $editMode) {
        $taskToEdit->status = 'completed';
        $taskToEdit->save();
        $_SESSION['success'] = true;
        header('Location: index.php');
        exit;
    } 
    elseif (isset($_POST['action_save'])) {
        if ($editMode) {
            $taskToEdit->title = $_POST['title'] ?? '';
            $taskToEdit->type_id = (int)($_POST['type_id'] ?? 1);
            $taskToEdit->location = $_POST['location'] ?? '';
            $taskToEdit->date_time = $_POST['date_time'] ?? '';
            $taskToEdit->duration = $_POST['duration'] ?? '';
            $taskToEdit->comment = $_POST['comment'] ?? '';
            $taskToEdit->status = $_POST['status'] ?? 'current';

            if ($taskToEdit->validate()) {
                $taskToEdit->save();
                $_SESSION['success'] = true;
                header('Location: index.php');
                exit;
            } 
            else {
                $errors = $taskToEdit->errors;
            }
        } 
        else {
            $newTask = new Task($_POST);
            if ($newTask->validate()) {
                $newTask->save();
                $_SESSION['success'] = true;
                header('Location: index.php');
                exit;
            } 
            else {
                $errors = $newTask->errors;
            }
        }
    }
}

$filter = $_GET['filter'] ?? 'current';
$filterDate = $_GET['date'] ?? null;

if (!empty($_GET['date_search'])) {
    $filter = 'date';
    $filterDate = $_GET['date_search'];
}

$tasks = Task::getTasks($filter, $filterDate);

require_once 'views/index_view.php';