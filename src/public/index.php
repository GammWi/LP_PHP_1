<?php

require_once '../../vendor/autoload.php';

use Slim\Http\Request;
use Slim\Http\Response;
use Illuminate\Database\Capsule\Manager as Manager;


$db = new Manager();

$app = new \Slim\App([
    'settings' => [
        'debug' => true,
        'displayErrorDetails' => true
    ]
]);

$container = $app->getContainer();
$container['view'] = function ($container){
    
    $view = new \Slim\Views\Twig(__DIR__.'/Views',[
        'cache' => false
    ]);

    $router = $container->get('router');
    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $view->addExtension(new \Slim\Views\TwigExtension($router, $uri));

    return $view;
};

$app->get('/test', function(Request $request, Response $response, $args){
    $response->getBody()->write("Hello world");
    return $response;
});

$app->get('/selectChamp', function (Request $request, Response $response, $args){
    $response->getBody()->write('Select your fighters');
    return $response;
});

$app->get('/connection', "\\dawa\\controllers\\userController:Index");


try {
    $app->run();
} catch (Throwable $e) {
    var_dump($e);
}


//$container=array();

//$container["settings"]=$config;

//$container["view"] = function($container){
//    $view = new \Slim\Views\Twig();
//};
