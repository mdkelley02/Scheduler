<?php
declare (strict_types = 1);
require_once __DIR__ . '/../vendor/autoload.php';
// header("Content-Type: application/json");

use App\App;
use \App\api\auth\AuthController;
use \App\api\users\UserController;
use \App\api\views\ViewController;

function create_app()
{
    $app = new App();
    $app->register_controller(new AuthController());
    $app->register_controller(new UserController());
    $app->register_controller(new ViewController());
    return $app;
}

$app = create_app();
$app->run();
