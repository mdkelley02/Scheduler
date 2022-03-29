<?php
declare (strict_types = 1);
namespace App;

class Router
{
    private $controllers;

    public function __construct()
    {
        $this->controllers = [];
    }

    public function register_route(string $controller_prefix, string $method, string $path, callable $handler): void
    {
        $hashed_path = hash_endpoint($controller_prefix . $method . $path);
        $this->handlers[$hashed_path] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler,
        ];
    }

    public function register_controller($controller): void
    {
        array_push($this->controllers, $controller);
    }

    public function route()
    {
        $hacky_prepend = "/public/index.php";
        if (!empty(file_get_contents('php://input')) && !json_decode(file_get_contents('php://input'))) {
            echo json_encode(["error" => "Invalid JSON body"]);
            return;
        }
        $_request["body"] = (array) json_decode(file_get_contents('php://input'));

        // check if middleware exists
        $middleware = null;
        foreach ($this->controllers as $controller) {
            foreach ((array) $controller->middleware as $_middleware) {
                if ($hacky_prepend . $controller->prefix . $_middleware['path'] === $_request['REQUEST_URI'] || $hacky_prepend . $controller->prefix . $_middleware['path'] === $_request['REQUEST_URI'] . '/') {
                    $middleware = $_middleware;
                }
            }
        }
        // check if handler exists
        $handler = null;
        foreach ($this->controllers as $controller) {
            foreach ((array) $controller->handlers as $_handler) {
                if ($_request['REQUEST_METHOD'] !== $_handler['method']) {
                    continue;
                }
                if ($hacky_prepend . $controller->prefix . $_handler['path'] === $_request['REQUEST_URI'] || $hacky_prepend . $controller->prefix . $_handler['path'] === $_request['REQUEST_URI'] . '/') {
                    $handler = $_handler;
                }
            }
        }
        // if handler has associated middleware, run middleware and pass the handler
        if ($handler !== null && $middleware !== null) {
            $middleware['handler']($_request, $handler['handler']);
        } elseif ($handler !== null) {
            $handler['handler']($_request);
        } else {
            echo json_encode(["error" => "Route does not exist"]);
        }
    }
}
