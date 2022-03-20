<?php
declare (strict_types = 1);
namespace App\api\auth;

use App\api\auth\AuthService;
use App\Controller;

function marshall_login(array $request_body)
{
    if (!isset($request_body['email']) || !isset($request_body['password'])) {
        return false;
    }
    if (!is_string($request_body['email']) || !is_string($request_body['password'])) {
        return false;
    }
    if (strlen($request_body['email']) < 1 || strlen($request_body['password']) < 1) {
        return false;
    }
    return true;
}

function marshall_register(array $request_body)
{
    if (!isset($request_body['full_name']) || !isset($request_body['email']) || !isset($request_body['password'])) {
        return false;
    }
    if (!is_string($request_body['full_name']) || !is_string($request_body['email']) || !is_string($request_body['password'])) {
        return false;
    }
    if (strlen($request_body['full_name']) < 1 || strlen($request_body['email']) < 1 || strlen($request_body['password']) < 1) {
        return false;
    }
    return true;
}

class AuthController extends Controller
{
    private $api;
    private $auth_service;
    public function __construct()
    {
        $this->auth_service = new AuthService();

        parent::__construct("/auth");
        $api = $this;

        $api::register_endpoint("POST", "/login", function (array $request) {
            $marshall_rc = marshall_login($request['body']);
            if (!$marshall_rc) {
                echo json_encode(["error" => "Invalid payload for login"]);
                return;
            }
            $email = $request['body']['email'];
            $password = hash('sha256', $request['body']['password']);
            try {
                $token = $this->auth_service->login($email, $password);
                echo json_encode(["success" => "User logged in"]);
            } catch (\Exception$e) {
                echo json_encode(["error" => $e->getMessage()]);
                return;
            }
        });

        $api::register_endpoint("POST", "/register", function (array $request) {
            $marshall_rc = marshall_register($request['body']);
            if (!$marshall_rc) {
                echo json_encode(["error" => "Invalid payload for user creation"]);
                return;
            }
            $full_name = $request['body']['full_name'];
            $email = $request['body']['email'];
            $password = hash('sha256', $request['body']['password']);
            $this->auth_service->register($full_name, $email, $password);
        });

    }
}
