<?php

require_once 'database/Database.php';

class Task {
    public $id;
    public $title;
    public $type_id;
    public $location;
    public $date_time;
    public $duration;
    public $comment;
    public $status;
    public $user_id;

    public $errors = [];

    public static $types = [
        1 => 'Встреча',
        2 => 'Звонок',
        3 => 'Совещание',
        4 => 'Дело'
    ];

    public static $durations = [
        '30 мин' => '30 минут',
        '1 час' => '1 час',
        '2 часа' => '2 часа',
        'Весь день' => 'Весь день'
    ];

    public function __construct($data = []) {
        if (!empty($data)) {
            $this->id = null; 
            $this->title = $data['title'] ?? '';
            $this->type_id = isset($data['type_id']) ? (int)$data['type_id'] : 1;
            $this->location = $data['location'] ?? '';
            $this->date_time = $data['date_time'] ?? '';
            $this->duration = $data['duration'] ?? '';
            $this->comment = $data['comment'] ?? '';
            $this->status = $data['status'] ?? 'current';
            $this->user_id = isset($data['user_id']) ? (int)$data['user_id'] : null;
        }
    }

    public function validate() {
        $this->errors = [];
        if (empty($this->title)) {
            $this->errors['title'] = 'Тема задачи обязательна к заполнению!';
        }
        if (empty($this->date_time)) {
            $this->errors['date_time'] = 'Укажите дату и время!';
        }
        return empty($this->errors);
    }

    public function save() {
        $this->date_time = str_replace('T', ' ', $this->date_time);

        if ($this->id) {
            $sql = "UPDATE tasks SET 
                    title = :title, 
                    type_id = :type_id, 
                    location = :location, 
                    date_time = :date_time, 
                    duration = :duration, 
                    comment = :comment, 
                    status = :status
                    WHERE id = :id AND user_id = :user_id";
            Database::exec($sql, [
                'title' => $this->title,
                'type_id' => $this->type_id,
                'location' => $this->location,
                'date_time' => $this->date_time,
                'duration' => $this->duration,
                'comment' => $this->comment,
                'status' => $this->status,
                'user_id' => $_SESSION['user_id'],
                'id' => $this->id
            ]);
        } else {
            $sql = "INSERT INTO tasks (title, type_id, location, date_time, duration, comment, status, user_id) 
                    VALUES (:title, :type_id, :location, :date_time, :duration, :comment, :status, :user_id)";
            Database::exec($sql, [
                'title' => $this->title,
                'type_id' => $this->type_id,
                'location' => $this->location,
                'date_time' => $this->date_time,
                'duration' => $this->duration,
                'comment' => $this->comment,
                'status' => 'current',
                'user_id' => $_SESSION['user_id']
            ]);
        }
    }

    public static function find($id) {
        $stmt = Database::query("SELECT * FROM tasks WHERE id = :id AND user_id = :user_id LIMIT 1", [
            'id' => (int)$id,
            'user_id' => $_SESSION['user_id']
        ]);
        return $stmt->fetchObject(self::class);
    }

    public static function getTasks($filter = 'current', $date = null) {
        $sql = "SELECT * FROM tasks WHERE user_id = :user_id ";
        $params = ['user_id' => $_SESSION['user_id']];

        if ($filter === 'current') {
            $sql .= "AND status = 'current' AND date_time >= NOW() ";
        } elseif ($filter === 'overdue') {
            $sql .= "AND status = 'current' AND date_time < NOW() ";
        } elseif ($filter === 'completed') {
            $sql .= "AND status = 'completed' ";
        } elseif ($filter === 'today') {
            $sql .= "AND DATE(date_time) = CURDATE() ";
        } elseif ($filter === 'tomorrow') {
            $sql .= "AND DATE(date_time) = DATE_ADD(CURDATE(), INTERVAL 1 DAY) ";
        } elseif ($filter === 'this_week') {
            $sql .= "AND date_time >= CURDATE() AND date_time <= DATE_ADD(CURDATE(), INTERVAL 7 DAY) ";
        } elseif ($filter === 'next_week') {
            $sql .= "AND date_time >= DATE_ADD(CURDATE(), INTERVAL 7 DAY) AND date_time <= DATE_ADD(CURDATE(), INTERVAL 14 DAY) ";
        } elseif ($filter === 'date' && $date) {
            $sql .= "AND DATE(date_time) = :date ";
            $params['date'] = $date;
        }

        $sql .= "ORDER BY date_time ASC";

        $stmt = Database::query($sql, $params);
        $tasks = [];
        while ($task = $stmt->fetchObject(self::class)) {
            $tasks[] = $task;
        }
        return $tasks;
    }
}