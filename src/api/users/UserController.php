<?php
declare (strict_types = 1);

namespace App\api\users;

use App\api\users\UserDao;
use App\Controller;

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
    return true;
}

class UserController extends Controller
{
    private $api;
    public function __construct()
    {
        $this->dao = new UserDao();

        parent::__construct("/users");
        $api = $this;

        $api->register_endpoint("GET", "/", function (array $request) {
            header("Content-Type: application/json");
            $users = $this->dao->get_all_users();
            echo json_encode($users);
        });

        // $api:register_middleware("/", function (array $request, callable $next) {
        //     $request['MIDDLEWARE_ARGS'] = "Hello from middleware";
        //     $next($request);
        // });

        $api::register_endpoint("POST", "/", function (array $request) {
            $marshall_rc = marshall_user_create($request['body']);
            if (!$marshall_rc) {
                echo json_encode(["error" => "Invalid payload for user creation"]);
                return;
            }
            $name = $request['body']['full_name'];
            $email = $request['body']['email'];
            $password = hash('sha256', $request['body']['password']);
            try {
                $this->dao->create_user($name, $email, $password);
            } catch (Exception $e) {
                echo json_encode(["error" => "Error creating user"]);
                return;
            }
            echo json_encode(["success" => "User created"]);
        });

    }
}
