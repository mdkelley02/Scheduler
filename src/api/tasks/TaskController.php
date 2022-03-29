<?php

declare (strict_types = 1);

namespace App\api\tasks;

ini_set('display_errors', 1);

use App\api\auth\AuthService;
use App\api\tasks\TaskDao;
use App\Controller;
use App\Response;

function marshall_task_create($request_body)
{
    echo var_dump($request_body);
    return;
    $available_fields = [
        'title',
        'description',
        'time_to_complete',
        'due_date',
        'start_time',
        'end_time',
    ];
    if (!isset($request_body['title'])) {
        return false;
    }
    if (!is_string($request_body['title'])) {
        return false;
    }
    if (sizeof($request_body) > sizeof($available_fields)) {
        return false;
    }
    foreach ($request_body as $key => $value) {
        if (in_array($key, $available_fields)) {
            if (!is_string($value)) {
                return false;
            }
        }
    }
    return true;
}

class TaskController extends Controller
{
    private $task_dao;
    private $api;
    private $auth_service;

    public function __construct()
    {
        parent::__construct("/tasks");
        $api = $this;
        $this->task_dao = new TaskDao();
        $this->auth_service = new AuthService();

        $api->register_middleware("/", function ($request, callable $next) {
            $headers = getallheaders();
            if (!$headers["Authorization"]) {
                $response = new Response("application/json", "Unauthorized", ["error" => "Missing Authorization header"], 400);
                $response->send();
                return;
            }
            $authorization = $headers["Authorization"];
            $jwt = explode(' ', $authorization)[1];
            if (!$jwt) {
                $response = new Response("application/json", "Unauthorized", ["error" => "Malformed auth header"], 400);
                $response->send();
                return;
            }
            try {
                $decoded_jwt = $this->auth_service->decode_jwt($jwt);
                $request["decoded_jwt"] = $decoded_jwt;
                return $next($request);
            } catch (Exception $e) {
                $response = new Response("application/json", "Unauthorized request", ["error" => $e->getMessage()], 401);
                $response->send();
                return;
            }
        });

        $api->register_endpoint("POST", "/", function ($request) {
            $marshall_rc = marshall_task_create($request["body"]);
            return;
            if (!$marshall_rc) {
                $response = new Response("application/json", "Invalid request", ["error" => "Incorrect payload for task creation"], 400);
                $response->send();
                return;
            }
            $user_id = $request["decoded_jwt"]["user_id"];
            if (!$user_id) {
                $response = new Response("application/json", "Invalid request", ["error" => "Invalid Authorization"], 400);
                $response->send();
                return;
            }
            try {
                $this->task_dao->create_task(
                    $user_id,
                    $request["body"]["title"],
                    $request["body"]["description"],
                    $request["body"]["time_to_complete"],
                    $request["body"]["due_date"],
                    $request["body"]["start_time"],
                    $request["body"]["end_time"]
                );
                $response = new Response("application/json", "Task created", ["payload" => $request["body"]], 201);
                $response->send();
            } catch (\Exception$e) {
                $response = new Response("application/json", "Invalid request", null, 400);
                $response->send();
                return;
            }
        });

        $api->register_endpoint("GET", "/", function ($request) {
            echo var_dump($request);
            return;
            $user_id = $request["decoded_jwt"]["user_id"];
            if (!$user_id) {
                $response = new Response("application/json", "Invalid request", ["error" => "Invalid Authorization"], 400);
                $response->send();
                return;
            }
            try {
                $tasks = $this->task_dao->get_all_tasks($user_id);
                $response = new Response("application/json", "Tasks retrieved", ["tasks" => $tasks], 200);
                $response->send();
            } catch (\Exception$e) {
                $response = new Response("application/json", "Invalid request", null, 400);
                $response->send();
                return;
            }
        });
    }

}
