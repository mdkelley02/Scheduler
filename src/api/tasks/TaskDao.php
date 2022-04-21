<?php
declare (strict_types = 1);
namespace App\api\tasks;

use App\Database;

class TaskDao
{
    private $db;

    public function __construct()
    {
        $db_instance = Database::getInstance();
        $this->conn = $db_instance->connect();
    }

    public function row_to_task($row)
    {
        return [
            "task_id" => $row['task_id'],
            "user_id" => $row['user_id'],
            "title" => $row['title'],
            "description" => $row['description'],
            "completed" => $row['completed'],
            "time_to_complete" => $row['time_to_complete'],
            "start_time" => $row['start_time'],
            "end_time" => $row['end_time'],
            "due_date" => $row['due_date'],
            "created_on" => $row['date_created'],
        ];
    }

    public function create_task($user_id, $title, $description, $time_to_complete, $due_date, $start_time, $end_time)
    {
        $fields = [
            'user_id' => $user_id,
            'title' => $title,
            'description' => $description,
            'time_to_complete' => $time_to_complete,
            'due_date' => $due_date,
            'start_time' => $start_time,
            'end_time' => $end_time,
        ];
        foreach ($fields as $key => $value) {
            if (empty($value)) {
                $fields[$key] = null;
            }
        }
        $sql = "insert into tasks (
                    user_id,
                    title,
                    description,
                    start_time,
                    end_time,
                    due_date,
                    time_to_complete,
                    completed
                )
                values (
                    :user_id,
                    :title,
                    :description,
                    :start_time,
                    :end_time,
                    :due_date,
                    :time_to_complete,
                    false
                );";
        $stmt = $this->conn->prepare($sql);
        foreach ($fields as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->execute();
    }

    public function get_all_tasks($user_id)
    {
        $sql = "select * from tasks where user_id = :user_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":user_id", $user_id);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        $tasks = [];
        foreach ($rows as $row) {
            $tasks[] = $row;
        }
        return $tasks;
    }

    public function delete_task($user_id, $task_id)
    {
        $sql = "delete from tasks where task_id = :task_id and user_id = :user_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":task_id", $task_id);
        $stmt->bindValue(":user_id", $user_id);
        $stmt->execute();
        return $stmt->rowCount();
    }
}
