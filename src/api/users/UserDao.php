<?php
declare (strict_types = 1);

namespace App\api\users;

use App\Database;

class UserDao
{
    private $conn;

    public function __construct()
    {
        $db_instance = Database::getInstance();
        $this->conn = $db_instance->connect();
    }

    private function row_to_user($row): array
    {
        return [
            "user_id" => $row["user_id"],
            "full_name" => $row["full_name"],
            "email" => $row["email"],
            "password" => $row["password"],
            "created_on" => $row["created_on"],
        ];
    }

    public function get_all_users()
    {
        $sql = "select * from users";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $users = [];
        foreach ($result as $row) {
            array_push($users, $this->row_to_user($row));
        }
        return $users;
    }

    public function get_user_by_id($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE user_id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $row = $stmt->fetch();
        if (!$row) {
            return null;
        }
        $user = $this->row_to_user($row);
        return $user;
    }

    public function get_user_by_email($email)
    {
        $sql = "select * from users where email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $row = $stmt->fetch();
        if (!$row) {
            return null;
        }
        $user = $this->row_to_user($row);
        return $user;
    }

    public function create_user($full_name, $email, $password)
    {
        $sql = "INSERT INTO users (full_name, email, password) VALUES (:full_name, :email, :password)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":full_name", $full_name);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $password);
        $stmt->execute();
    }

    public function update_user($id, $name, $email, $password)
    {
        $stmt = $this->conn->prepare("UPDATE users SET name = :name, email = :email, password = :password WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $password);
        $stmt->execute();
    }

    public function delete_user($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
    }
}
