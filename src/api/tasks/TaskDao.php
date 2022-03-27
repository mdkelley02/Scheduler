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

    public function create_task(
        $user_id, $title, $description,
        $time_to_complete, $due_date, $start_time, $end_time
    ) {
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
                )";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':start_time', $start_time);
            $stmt->bindParam(':end_time', $end_time);
            $stmt->bindParam(':due_date', $due_date);
            $stmt->bindParam(':time_to_complete', $time_to_complete);
            $stmt->execute();
    }
}
