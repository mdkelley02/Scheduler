<?php

declare (strict_types = 1);
namespace App\api\tasks;

use App\api\auth\AuthService;
use App\api\tasks\TaskDao;
use App\Controller;

class TaskController extends Controller
{
    private $task_dao;
    private $api;

    public function __construct()
    {
        parent::__construct("/tasks");
        $api = $this;
        $this->task_dao = new TaskDao();

        $api->register_middleware(function ($request, $next) {
            $auth_service = new AuthService();
            $jwt = $request->get_header("Authorization");
            if (!$jwt) {
                return json_encode([
                    "error" => "No JWT provided",
                ]);
            }
            try {
                $decoded_jwt = $auth_service->decode_jwt($jwt);
            } catch (\Exception$e) {
                return json_encode([
                    "error" => $e->getMessage(),
                ]);
            }
            $request['jwt_payload'] = $decoded_jwt;
            return $next($request);
        });

        $api->register_endpoint("GET", "/", function () use ($api) {
            $tasks = $api->task_dao->get_all_tasks();
            $api->render_json($tasks);
        });
    }

}
