<?php

session_start();
require_once '../../vendor/autoload.php';
require_once '../config/config.inc.php';

use Slim\Http\Request;
use Slim\Http\Response;
use Illuminate\Database\Capsule\Manager as DB;
use dawa\models\Character as chara;
use dawa\middleware\AuthMiddleware;


//$container = $app->getContainer();

$container = array();

$container['flash'] = function ($container){
    return new \Slim\Flash\Messages;
};

$container['auth'] = function ($container){
    return new dawa\controllers\userController($container);
};

$container["view"] = function ($container){
    
    $view = new \Slim\Views\Twig(__DIR__.'/Views',[
        'cache' => false
    ]);

    $router = $container->get('router');
    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $view->addExtension(new \Slim\Views\TwigExtension($router, $uri));
    $view->getEnvironment()->addGlobal('auth', new dawa\controllers\userController($container));
    $view->getEnvironment()->addGlobal('flash', $container->flash);
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


$app->get('/selectChamp', "\\dawa\\controllers\\champSelectController:Index")->setName('home');



$app->get('/auth/signin', "\\dawa\\controllers\\userController:signIn")->setName('auth.signin');
$app->post('/auth/signin', "\\dawa\\controllers\\userController:postSignIn");
$app->get('/auth/signout', "\\dawa\\controllers\\userController:signOut")->setName('auth.signout');





$app->get('/fight', "\\dawa\\controllers\\fightController:Index")->setName('fight');
$app->post('/fight', "\\dawa\\controllers\\fightController:Index")->setName('fight');


//ROUTE TEMPORAIRE CREATION DESIGN
$app->get('/TEMPLATEselectChamp', function(Request $request, Response $response, $args) {
   $this->view->render($response, 'TEMPLATE/TEMPLATEselectChamp.html.twig');
});
//ROUTE TEMPORAIRE CREATION DESIGN

$app->group('', function(){
    $this->get('/admin/panel', "\\dawa\\controllers\\userController:panel")->setName('admin.panel');

    $this->get('/admin/add', "\\dawa\\controllers\\userController:ajouterAdmin")->setName('admin.add');
    $this->post('/admin/add', "\\dawa\\controllers\\userController:postAjouterAdmin");
    $this->post('/modifHero',"\\dawa\\controllers\\heroController:modifierHero")->setName('modifHero');

    $this->post('/supprHero',"\\dawa\\controllers\\heroController:supprimerHero")->setName('supprHero');

    $this->post('/modifMonster',"\\dawa\\controllers\\monstreController:modifierMonster")->setName('modifMonster');

    $this->post('/supprMonster',"\\dawa\\controllers\\monstreController:supprimerMonster")->setName('supprMonster');
    $this->get('/createHero', "\\dawa\\controllers\\heroController:CreerHero")->setName('creerHero');

    $this->get('/createMonster', "\\dawa\\controllers\\monstreController:CreerMonster")->setName('CreerMonster');

    $this->post('/valCreateMonster', "\\dawa\\controllers\\monstreController:insererMonster");

    $this->post('/valCreateHero', "\\dawa\\controllers\\heroController:insererHero");
})->add(new AuthMiddleware($app->getContainer()));

try {
    $app->run();
} catch (Throwable $e) {
    var_dump($e);
}
