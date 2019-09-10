<?php

require_once '../../vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Manager;
use Slim\app as App;

$db = new Manager();

$app = new App();

$app->get('/test', function(){
    echo 'Hello World';
});

