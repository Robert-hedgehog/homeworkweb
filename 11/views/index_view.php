<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Мой календарь</title>
    <style>
        body { 
            font-family: sans-serif; 
            max-width: 800px; 
            margin: 20px auto; 
            padding: 10px; 
            background-color: #fff;
            color: #000;
        }
        h1 { 
            font-size: 36px;
            margin-bottom: 25px; 
        }
        .frame { 
            border: 2px solid #000; 
            padding: 20px; 
            margin-bottom: 30px; 
            position: relative;
            background: #fff;
        }
        .frame-title { 
            font-weight: bold; 
            font-size: 18px;
            position: absolute;
            top: -12px;
            left: 15px;
            background: #fff; 
            padding: 0 10px; 
        }
        .form-group { 
            margin-bottom: 15px; 
            display: flex; 
            align-items: center;
        }
        .form-group label { 
            width: 140px; 
            display: inline-block; 
            text-align: right;
            margin-right: 15px;
            font-weight: bold;
        }
        .form-group input, 
        .form-group select, 
        .form-group textarea { 
            flex-grow: 1; 
            padding: 6px 10px; 
            font-family: inherit; 
            font-size: 15px;
            border: 2px solid #000;
            background: #fff;
            box-sizing: border-box;
        }
        .form-group textarea {
            resize: vertical;
        }
        .error { 
            color: red; 
            font-size: 13px; 
            margin-left: 155px; 
            margin-top: -10px;
            margin-bottom: 10px;
        }
        
        .btn-sketch {
            border: 2px solid #000;
            background: #fff;
            padding: 6px 20px;
            font-weight: bold;
            font-family: inherit;
            font-size: 15px;
            cursor: pointer;
            transition: transform 0.05s, box-shadow 0.05s;
        }
        .btn-sketch:active {
            transform: translate(1px, 1px);
            box-shadow: 1px 1px 0px #000;
        }
        .btn-complete { background: #e0ffe0; }
        .btn-delete { background: #ffe0e0; color: red; }

        .filters { 
            margin-bottom: 15px; 
            display: flex; 
            justify-content: space-between;
            align-items: center; 
            flex-wrap: wrap;
            gap: 15px;
        }
        .filter-controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .filter-controls select,
        .filter-controls input[type="date"] {
            padding: 5px;
            font-family: inherit;
            font-size: 14px;
            border: 2px solid #000;
            background: #fff;
        }
        .quick-links {
            white-space: nowrap;
            font-size: 14px;
        }
        .quick-links a { 
            margin: 0 3px; 
            text-decoration: underline; 
            color: blue; 
        }
        .quick-links a.active { 
            font-weight: bold; 
            text-decoration: none; 
            color: black; 
        }

        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 15px; 
            border: 2px solid #000;
        }
        th, td { 
            border-right: 2px solid #000; 
            padding: 8px 10px; 
            text-align: left; 
            font-size: 14px;
        }
        th:last-child, td:last-child {
            border-right: none;
        }
        th { 
            background-color: #dcdcdc; 
            border-bottom: 2px solid #000;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>

    <h1>Мой календарь</h1>

    <p>Привет, <b><?= htmlspecialchars($_SESSION['username']) ?></b>! | <a href="index.php?route=logout" style="color: red;">Выйти</a></p>

    <?php if ($success): ?>
        <div style="border: 2px solid green; color: green; padding: 10px; margin-bottom: 20px; font-weight: bold;">
            Операция выполнена успешно!
        </div>
    <?php endif; ?>

    <div class="frame">
        <span class="frame-title"><?= $editMode ? 'Редактирование задачи' : 'Новая задача' ?></span>
        <form action="" method="POST">
            <div class="form-group">
                <label>Тема:</label>
                <input type="text" name="title" value="<?= htmlspecialchars($editMode ? $taskToEdit->title : ($_POST['title'] ?? '')) ?>">
            </div>
            <?php if (isset($errors['title'])): ?><div class="error"><?= $errors['title'] ?></div><?php endif; ?>

            <div class="form-group">
                <label>Тип:</label>
                <select name="type_id">
                    <?php foreach (Task::$types as $id => $name): ?>
                        <option value="<?= $id ?>" <?= (($editMode ? $taskToEdit->type_id : ($_POST['type_id'] ?? 1)) == $id) ? 'selected' : '' ?>><?= $name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Место:</label>
                <input type="text" name="location" value="<?= htmlspecialchars($editMode ? $taskToEdit->location : ($_POST['location'] ?? '')) ?>">
            </div>

            <div class="form-group">
                <label>Дата и время:</label>
                <input type="datetime-local" name="date_time" value="<?= htmlspecialchars($editMode ? date('Y-m-d\TH:i', strtotime($taskToEdit->date_time)) : ($_POST['date_time'] ?? '')) ?>">
            </div>
            <?php if (isset($errors['date_time'])): ?><div class="error"><?= $errors['date_time'] ?></div><?php endif; ?>

            <div class="form-group">
                <label>Длительность:</label>
                <select name="duration">
                    <?php foreach (Task::$durations as $key => $name): ?>
                        <option value="<?= $key ?>" <?= (($editMode ? $taskToEdit->duration : ($_POST['duration'] ?? '')) === $key) ? 'selected' : '' ?>><?= $name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <?php if ($editMode): ?>
                <div class="form-group">
                    <label>Статус:</label>
                    <select name="status">
                        <option value="current" <?= $taskToEdit->status === 'current' ? 'selected' : '' ?>>Активная</option>
                        <option value="completed" <?= $taskToEdit->status === 'completed' ? 'selected' : '' ?>>Выполненная</option>
                    </select>
                </div>
            <?php endif; ?>

            <div class="form-group">
                <label>Комментарий:</label>
                <textarea name="comment" rows="3"><?= htmlspecialchars($editMode ? $taskToEdit->comment : ($_POST['comment'] ?? '')) ?></textarea>
            </div>

            <div style="text-align: left; margin-left: 155px; display: flex; gap: 10px; flex-wrap: wrap; align-items: center;">
                <button type="submit" name="action_save" value="1" class="btn-sketch">
                    <?= $editMode ? 'Сохранить изменения' : 'Добавить' ?>
                </button>

                <?php if ($editMode): ?>
                    <?php if ($taskToEdit->status !== 'completed'): ?>
                        <button type="submit" name="action_complete" value="1" class="btn-sketch btn-complete">Выполнено</button>
                    <?php endif; ?>
                    <button type="submit" name="action_delete" value="1" onclick="return confirm('Вы действительно хотите удалить эту задачу?')" class="btn-sketch btn-delete">Удалить</button>
                    <a href="index.php" style="margin-left: 10px; color: gray; text-decoration: underline;">Отмена</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <div class="frame">
        <span class="frame-title">Список задач</span>
        
        <div class="filters">
            <div class="filter-controls">
                <form action="" method="GET" id="filterForm" style="margin: 0;">
                    <select name="filter" onchange="document.getElementById('filterForm').submit()">
                        <option value="current" <?= $filter === 'current' ? 'selected' : '' ?>>Текущие задачи</option>
                        <option value="overdue" <?= $filter === 'overdue' ? 'selected' : '' ?>>Просроченные задачи</option>
                        <option value="completed" <?= $filter === 'completed' ? 'selected' : '' ?>>Выполненные задачи</option>
                    </select>
                </form>

                <form action="" method="GET" id="dateForm" style="margin: 0;">
                    <input type="date" name="date_search" value="<?= $filter === 'date' ? htmlspecialchars($filterDate) : '' ?>" onchange="this.form.submit()">
                </form>
            </div>

            <div class="quick-links">
                <a href="?filter=today" class="<?= $filter === 'today' ? 'active' : '' ?>">сегодня</a> |
                <a href="?filter=tomorrow" class="<?= $filter === 'tomorrow' ? 'active' : '' ?>">завтра</a> |
                <a href="?filter=this_week" class="<?= $filter === 'this_week' ? 'active' : '' ?>">на эту неделю</a> |
                <a href="?filter=next_week" class="<?= $filter === 'next_week' ? 'active' : '' ?>">на след. неделю</a>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th style="width: 15%">Тип</th>
                    <th style="width: 50%">Задача</th>
                    <th style="width: 15%">Место</th>
                    <th style="width: 20%">Дата и время</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($tasks)): ?>
                    <tr>
                        <td colspan="4" style="text-align: center; color: gray;">Задач по выбранному фильтру не найдено</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($tasks as $task): ?>
                        <tr style="<?= ($editMode && $taskToEdit->id === $task->id) ? 'background-color: #fff3cd;' : '' ?>">
                            <td><?= Task::$types[$task->type_id] ?? 'Дело' ?></td>
                            <td>
                                <a href="?edit=<?= $task->id ?><?= $filter !== 'current' ? '&filter='.$filter : '' ?>" style="color: blue; text-decoration: underline; font-weight: <?= ($editMode && $taskToEdit->id === $task->id) ? 'bold' : 'normal' ?>;">
                                    <?= htmlspecialchars($task->title) ?>
                                </a>
                            </td>
                            <td><?= htmlspecialchars($task->location ?: '-') ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($task->date_time)) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>
</html>