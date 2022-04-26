<?php
declare (strict_types = 1);

namespace App\api\users;

use App\api\auth\AuthService;
use App\api\users\UserDao;
use App\Controller;
use App\Response;

function marshall_user_create($request_body)
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
    if (strpos($request_body['email'], '@') === false) {
        return false;
    }
    return true;
}

class UserController extends Controller
{
    private $api;
    public function __construct()
    {
        $this->dao = new UserDao();
        $this->auth_service = new AuthService();

        parent::__construct("/users");
        $api = $this;

        $api->register_endpoint("GET", "/me", function (array $request) {
            $user = $this->dao->get_user_by_id($request['decoded_jwt']['user_id']);
            if (!$user) {
                $response = new Response("Content-Type: application/json", "Not Found", ["error" => "User not found"], 404);
                $response->send();
                return;
            }
            $response = new Response("Content-Type: application/json", "User retrieved", ["user" => array(
                "user_id" => $user['user_id'],
                "full_name" => $user['full_name'],
                "email" => $user['email'],
                "created_on" => $user['created_on'],
            )], 200);
            $response->send();
        });

        $api->register_middleware("/me", function ($request, callable $next) {
            $headers = getallheaders();
            if (!$headers["Authorization"]) {
                $response = new Response("Content-Type: application/json", "Unauthorized", ["error" => "Missing Authorization header"], 400);
                $response->send();
                return;
            }
            $authorization = $headers["Authorization"];
            $jwt = explode(' ', $authorization)[1];
            if (!$jwt) {
                $response = new Response("Content-Type: application/json", "Unauthorized", ["error" => "Malformed auth header"], 400);
                $response->send();
                return;
            }
            try {
                $decoded_jwt = $this->auth_service->decode_jwt($jwt);
                $request["decoded_jwt"] = $decoded_jwt;
                return $next($request);
            } catch (Exception $e) {
                $response = new Response("Content-Type: application/json", "Unauthorized request", ["error" => $e->getMessage()], 401);
                $response->send();
                return;
            }
        });
    }
}
