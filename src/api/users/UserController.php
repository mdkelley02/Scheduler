<?php
declare (strict_types = 1);

namespace App\api\users;

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

        parent::__construct("/users");
        $api = $this;

        $api->register_endpoint("GET", "/", function (array $request) {
            $users = $this->dao->get_all_users();
            $response = new Response("application/json", "Success", $users);
            $response->send();
        });
    }
}
