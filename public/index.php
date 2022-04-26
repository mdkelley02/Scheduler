<?php
declare (strict_types = 1);
require_once __DIR__ . '/../vendor/autoload.php';

use App\App;
use \App\api\auth\AuthController;
use \App\api\tasks\TaskController;
use \App\api\users\UserController;
use \App\api\views\ViewController;

function create_app()
{
    $app = new App();
    $app->register_controller(new AuthController());
    $app->register_controller(new UserController());
    $app->register_controller(new TaskController());
    $app->register_controller(new ViewController());
    return $app;
}
// $input = fgets(STDIN);
$input = array(
    "_SERVER" => $_SERVER,
    "_GET" => $_GET,
    "_POST" => $_POST,
    "_FILES" => $_FILES,
    "_COOKIE" => $_COOKIE,
    "_SESSION" => $_SESSION,
    "_REQUEST" => $_REQUEST,
    "_ENV" => $_ENV,
);
// if (!defined('STDOUT')) {
//     define('STDOUT', fopen('php://stdout', 'wb'));
// }

fwrite("php://stderr" var_dump($input));
$app = create_app();
$app->run();
