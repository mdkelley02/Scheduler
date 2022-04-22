<?php
declare (strict_types = 1);
namespace App\api\auth;

use App\api\auth\AuthService;
use App\Controller;
use App\Response;

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
    if (!preg_match('/^[^@]+@[^@]+\.[^@]+$/', $request_body['email'])) {
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
                $jwt = $this->auth_service->login($email, $password);
                $response = new Response("Content-Type: application/json", "Login successful", ["jwt" => $jwt]);
                $response->send();
            } catch (\Exception$e) {
                $response = new Response("Content-Type: application/json", "Login failed", ["error" => $e->getMessage()], 401);
                $response->send();
                return;
            }
        });

        $api::register_endpoint("POST", "/register", function (array $request) {
            $marshall_rc = marshall_register($request['body']);
            if (!$marshall_rc) {
                header("HTTP/1.1 400 Bad Request");
                echo json_encode(["error" => "Invalid payload for user creation"]);
                return;
            }
            $full_name = $request['body']['full_name'];
            $email = $request['body']['email'];
            $password = hash('sha256', $request['body']['password']);
            try {
                $this->auth_service->register($full_name, $email, $password);
                $response = new Response("Content-Type: application/json", "User creation successful");
                $response->send();
            } catch (\Exception$e) {
                $response = new Response("Content-Type: application/json", "User creation failed", ["error" => $e->getMessage()], 400);
                $response->send();
                return;
            }
        });

        $api::register_endpoint("POST", "/validate", function (array $request) {
            $headers = getallheaders();
            $auth_header = $headers["Authorization"];
            $jwt = substr($auth_header, 7);
            if (!$jwt) {
                $response = new Response("Content-Type: application/json", "No JWT provided", ["error" => "No JWT provided"], 401);
                $response->send();
                return;
            }
            try {
                $this->auth_service->decode_jwt($jwt);
                $response = new Response("Content-Type: application/json", "JWT is valid");
                $response->send();
                return;
            } catch (\Exception$e) {
                $response = new Response("Content-Type: application/json", "JWT is invalid", ["error" => $e->getMessage()], 401);
                $response->send();
                return;
            }
        });
    }

}
