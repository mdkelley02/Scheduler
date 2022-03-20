<?php

declare (strict_types = 1);

use App\AbstractNamespace;

$tasks = new AbstractNamespace('/tasks', 'tasks');

$tasks->get('/', function ($request) {
    echo 'Hello World!';
});
