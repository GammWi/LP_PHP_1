<?php

require_once '../../vendor/autoload.php';
require_once '../config/config.inc.php';

use Slim\Http\Request;
use Slim\Http\Response;
use Illuminate\Database\Capsule\Manager as DB;
use dawa\models\Character as chara;



//$container = $app->getContainer();

$container = array();


$container["view"] = function ($container){
    
    $view = new \Slim\Views\Twig(__DIR__.'/Views',[
        'cache' => false
    ]);

    $router = $container->get('router');
    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $view->addExtension(new \Slim\Views\TwigExtension($router, $uri));

    return $view;
};



$container['settings'] = $config;
//$container['settings'] = $config;
//Eloquent
$app = new \Slim\App($container,[
    'settings' => [
        'debug' => true,
        'displayErrorDetails' => true
    ]
]);
$capsule = new DB();
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function ($container) use ($capsule) {
    return $capsule;
};

$app->get('/test', function(Request $request, Response $response, $args){
    $response->getBody()->write("Hello world");
    return $response;
});

$app->get('/selectChamp', "\\dawa\\controllers\\champSelectController:Index");



$app->get('/connection', "\\dawa\\controllers\\userController:Index");

$app->get('/createCharacter', "\\dawa\\controllers\\characterController:Index");

$app->get('/createHero', "\\dawa\\controlles\\heroController:Index");





try {
    $app->run();
} catch (Throwable $e) {
    var_dump($e);
}
