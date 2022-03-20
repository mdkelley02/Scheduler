<?php
declare (strict_types = 1);
namespace App;

abstract class Controller
{
    public $prefix;
    public $handlers;
    public $middleware;

    public function __construct(string $prefix)
    {
        $this->prefix = $prefix;
        $this->handlers = [];
        $this->middleware = [];
    }

    public function create_endpoint(string $method, string $endpoint, callable $handler)
    {
        return [
            'method' => $method,
            'path' => $endpoint,
            'handler' => $handler,
        ];
    }

    public function register_endpoint(string $method, string $endpoint, callable $handler): void
    {
        array_push($this->handlers, $this->create_endpoint($method, $endpoint, $handler));
    }

    public function register_middleware(string $endpoint, callable $middleware): void
    {
        array_push($this->middleware, [
            'path' => $endpoint,
            'handler' => $middleware,
        ]);
    }
}
