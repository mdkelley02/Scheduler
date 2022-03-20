<?php
declare (strict_types = 1);
namespace App;

class App
{
    private $router;
    private $controllers;

    public function __construct()
    {
        $this->router = new Router();
    }

    public function register_controller(Controller $controller)
    {
        $this->router->register_controller($controller);
    }

    public function run()
    {
        $this->router->route();
    }
}
