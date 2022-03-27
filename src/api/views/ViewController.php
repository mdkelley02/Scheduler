<?php

declare (strict_types = 1);
namespace App\api\views;

use App\Controller;

class ViewController extends Controller
{
    private $api;
    public function __construct()
    {
        parent::__construct("/app");
        $api = $this;

        $api->register_endpoint("GET", "/", function (array $request) {
            require_once __DIR__ . "/templates/Home.php";
        });

        $api->register_endpoint("GET", "/login", function (array $request) {
            require_once __DIR__ . "/templates/Login.php";
        });

        $api->register_endpoint("GET", "/register", function (array $request) {
            require_once __DIR__ . "/templates/Register.php";
        });

        $api->register_endpoint("GET", "/create-task", function (array $request) {
            require_once __DIR__ . "/templates/CreateTask.php";
        });

        $api->register_endpoint("GET", "/calendar", function (array $request) {
            require_once __DIR__ . "/templates/Calendar.php";
        });

    }
}
