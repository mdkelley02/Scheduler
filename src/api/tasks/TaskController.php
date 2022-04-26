<?php

declare (strict_types = 1);

namespace App\api\tasks;

use App\api\auth\AuthService;
use App\api\tasks\TaskDao;
use App\Controller;
use App\Response;

function marshall_task_create($request_body)
{
    $available_fields = [
        'title',
        'description',
        'time_to_complete',
        'due_date',
        'start_time',
        'end_time',
    ];
    if (!key_exists('title', $request_body)) {
        return false;
    }
    if (!is_string($request_body['title'])) {
        return false;
    }
    if (sizeof($request_body) > sizeof($available_fields)) {
        return false;
    }
    foreach ($request_body as $key => $value) {
        if (key_exists($key, $available_fields)) {
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
            } catch (\Exception$e) {
                $response = new Response("Content-Type: application/json", "Unauthorized request", ["error" => $e->getMessage()], 401);
                $response->send();
                return;
            }
        });

        // create task
        $api->register_endpoint("POST", "/", function ($request) {
            $marshall_rc = marshall_task_create($request["body"]);
            if (!$marshall_rc) {
                $response = new Response("Content-Type: application/json", "Invalid request", ["error" => "Incorrect payload for task creation"], 400);
                $response->send();
                return;
            }
            $user_id = $request["decoded_jwt"]["user_id"];
            if (!$user_id) {
                $response = new Response("Content-Type: application/json", "Invalid request", ["error" => "Invalid Authorization"], 400);
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
            } catch (\Exception$e) {
                $response = new Response("Content-Type: application/json", "Invalid request", null, 400);
                $response->send();
                return;
            }
        });

        // get all tasks
        $api->register_endpoint("GET", "/", function ($request) {
            $user_id = $request["decoded_jwt"]["user_id"];
            if (!$user_id) {
                $response = new Response("Content-Type: application/json", "Invalid request", ["error" => "Invalid Authorization"], 400);
                $response->send();
                return;
            }
            $query_string = $request["QUERY_STRING"];
            $query = explode("=", $query_string)[1];
            switch ($query) {
                case "all":
                    $tasks = $this->task_dao->get_all_tasks($user_id);
                    $response = new Response("Content-Type: application/json", "All tasks", ["tasks" => $tasks], 200);
                    $response->send();
                    break;
                case "completed":
                    $tasks = $this->task_dao->get_completed_tasks($user_id);
                    $response = new Response("Content-Type: application/json", "All completed tasks", ["tasks" => $tasks], 200);
                    $response->send();
                    break;
                case "incomplete":
                    $tasks = $this->task_dao->get_incomplete_tasks($user_id);
                    $response = new Response("Content-Type: application/json", "All incomplete tasks", ["tasks" => $tasks], 200);
                    $response->send();
                    break;
                default:
                    $tasks = $this->task_dao->get_all_tasks($user_id);
                    $response = new Response("Content-Type: application/json", "All tasks", ["tasks" => $tasks], 200);
                    $response->send();
                    break;
            }
        });

        // delete task by id
        $api->register_endpoint("DELETE", "/", function ($request) {
            $user_id = $request["decoded_jwt"]["user_id"];
            if (!$user_id) {
                $response = new Response("Content-Type: application/json", "Invalid request", ["error" => "Invalid Authorization"], 400);
                $response->send();
                return;
            }
            $query_string = $request["QUERY_STRING"];
            if (!$query_string) {
                $response = new Response("Content-Type: application/json", "Invalid request", ["error" => "Missing query string"], 400);
                $response->send();
                return;
            }
            $task_id = explode("=", $query_string)[1];
            if (!$task_id) {
                $response = new Response("Content-Type: application/json", "Invalid request", ["error" => "Missing task_id"], 400);
                $response->send();
                return;
            }
            if (!is_numeric($task_id)) {
                $response = new Response("Content-Type: application/json", "Invalid request", ["error" => "Invalid task_id"], 400);
                $response->send();
                return;
            }
            try {
                $delete_count = $this->task_dao->delete_task($user_id, $task_id);
                if ($delete_count == 0) {
                    $response = new Response("Content-Type: application/json", "Invalid request", ["error" => "Task not found"], 400);
                    $response->send();
                    return;
                }
                $response = new Response("Content-Type: application/json", "Task deleted", ["task_id" => $task_id], 200);
                $response->send();
            } catch (Exception $e) {
                $response = new Response("Content-Type: application/json", "Invalid request", null, 400);
                $response->send();
                return;
            }
        });

        // update task by id
        $api->register_endpoint("PUT", "/", function ($request) {
            $user_id = $request["decoded_jwt"]["user_id"];
            if (!$user_id) {
                $response = new Response("Content-Type: application/json", "Invalid request", ["error" => "Invalid Authorization"], 400);
                $response->send();
                return;
            }
            $query_string = $request["QUERY_STRING"];
            if (!$query_string) {
                $response = new Response("Content-Type: application/json", "Invalid request", ["error" => "Missing query string"], 400);
                $response->send();
                return;
            }
            $task_id = explode("=", $query_string)[1];
            if (!$task_id) {
                $response = new Response("Content-Type: application/json", "Invalid request", ["error" => "Missing task_id"], 400);
                $response->send();
                return;
            }
            if (!is_numeric($task_id)) {
                $response = new Response("Content-Type: application/json", "Invalid request", ["error" => "Invalid task_id"], 400);
                $response->send();
                return;
            }
            $marshall_rc = marshall_task_create($request["body"]);
            if (!$marshall_rc) {
                $response = new Response("Content-Type: application/json", "Invalid request", ["error" => "Incorrect payload for task update"], 400);
                $response->send();
                return;
            }

            $update_count = $this->task_dao->update_task(
                $user_id,
                $task_id,
                $request["body"]["title"] ?? null,
                $request["body"]["description"] ?? null,
                $request["body"]["time_to_complete"] ?? null,
                $request["body"]["due_date"] ?? null,
                $request["body"]["start_time"] ?? null,
                $request["body"]["end_time"] ?? null,
                $request["body"]["completed"] ?? null
            );
            // echo $update_count;
            // if ($update_count == 0) {
            //     $response = new Response("Content-Type: application/json", "Invalid request", ["error" => "Task not found"], 400);
            //     $response->send();
            //     return;
            // }
            // $response = new Response("Content-Type: application/json", "Task updated", ["task_id" => $task_id], 200);
        });
    }

}
