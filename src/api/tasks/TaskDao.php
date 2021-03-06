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

    public function get_task($task_id)
    {
        $sql = "select * from tasks where task_id = :task_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":task_id", $task_id);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row;
    }

    public function get_completed_tasks($user_id)
    {
        $sql = "select * from tasks where user_id = :user_id and completed = true";
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

    public function get_incomplete_tasks($user_id)
    {
        $sql = "select * from tasks where user_id = :user_id and completed = false";
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

    public function update_task($user_id, $task_id, $title, $description, $time_to_complete, $due_date, $start_time, $end_time, $completed)
    {
        $fields_with_null = [
            'title' => $title,
            'description' => $description,
            'time_to_complete' => $time_to_complete,
            'due_date' => $due_date,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'completed' => $completed,
        ];

        $fields = [];
        // append all fields without null value to $fields
        foreach ($fields_with_null as $key => $value) {
            if (!empty($value)) {
                $fields[$key] = $value;
            }
        }
        $columns_to_update_string = "";
        foreach ($fields as $key => $value) {
            $columns_to_update_string .= "$key = :$key, ";
        }

        $columns_to_update_string = rtrim($columns_to_update_string, ", ");
        $sql = "update tasks set $columns_to_update_string where task_id = :task_id and user_id = :user_id";
        $stmt = $this->conn->prepare($sql);
        foreach ($fields as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->bindValue(":task_id", $task_id);
        $stmt->bindValue(":user_id", $user_id);
        $stmt->execute();
        return $stmt->rowCount();
    }
}
