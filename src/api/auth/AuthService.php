<?php
declare (strict_types = 1);
namespace App\api\auth;

use App\api\users\UserDao;

class AuthService
{
    private $user_dao;

    public function __construct()
    {
        $this->user_dao = new UserDao();
    }

    public function login(string $email, string $password)
    {
        $user = $this->user_dao->get_user_by_email($email);
        if (!$user["email"]) {
            throw new \Exception("User not found");
        }
        if ($user['password'] != $password) {
            throw new \Exception("Invalid password");
        }
    }

    public function register($full_name, $email, $password)
    {
        $user = $this->user_dao->get_user_by_email($email);
        if ($user != null) {
            echo json_encode(["error" => "User already exists"]);
            return;
        }
        $this->user_dao->create_user($full_name, $email, $password);
        echo json_encode(["success" => "User created"]);
    }
}
