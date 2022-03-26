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
            "id" => $row['id'],
            "name" => $row['name'],
            "description" => $row['description'],
            "completed" => $row['completed'],
            "time_estimate" => $row['time_estimate'],
            "start_time" => $row['start_time'],
            "end_time" => $row['end_time'],
            "created_on" => $row['date_created'],
        ];
    }

    public function get_all_tasks($user_id)
    {
        $sql = "select * from tasks where user_id = :user_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $tasks = [];
        if (count($result) == 0 || !$result) {
            return $tasks;
        }
        foreach ($result as $row) {
            array_push($tasks, $this->row_to_task($row));
        }
        return $tasks;
    }

    public function get_all_complete_tasks($user_id)
    {
        $sql = "select * from tasks where user_id = :user_id and completed = 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $tasks = [];
        if (count($result) == 0 || !$result) {
            return $tasks;
        }
        foreach ($result as $row) {
            array_push($tasks, $this->row_to_task($row));
        }
        return $tasks;
    }

    public function get_all_incomplete_tasks($user_id)
    {
        $sql = "select * from tasks where user_id = :user_id and completed = 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $tasks = [];
        if (count($result) == 0 || !$result) {
            return $tasks;
        }
        foreach ($result as $row) {
            array_push($tasks, $this->row_to_task($row));
        }
        return $tasks;
    }

    public function get_task($user_id, $task_id)
    {
        $sql = "select * from tasks where user_id = :user_id and id = :task_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":task_id", $task_id);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $tasks = [];
        if (count($result) == 0 || !$result) {
            return $tasks;
        }
        foreach ($result as $row) {
            array_push($tasks, $this->row_to_task($row));
        }
        return $tasks;
    }

    public function complete_task($user_id, $task_id)
    {
        $sql = "update tasks set completed = 1 where user_id = :user_id and id = :task_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":task_id", $task_id);
        $stmt->execute();
    }

    public function create_task($user_id, $name, $description, $time_estimate)
    {
        $sql = "insert into tasks (user_id, name, description, time_estimate) values (:user_id, :name, :description, :time_estimate)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":time_estimate", $time_estimate);
        $stmt->execute();
    }

    public function update_task($user_id, $task_id, $name, $description, $time_estimate)
    {
        $sql = "update tasks set name = :name, description = :description, time_estimate = :time_estimate where user_id = :user_id and id = :task_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":task_id", $task_id);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":time_estimate", $time_estimate);
        $stmt->execute();
    }

    public function delete_task($user_id, $task_id)
    {
        $sql = "delete from tasks where user_id = :user_id and id = :task_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":task_id", $task_id);
        $stmt->execute();
    }
}
