<?php

namespace dawa\controllers;

use Slim\Slim;
use dawa\models\Hero as Hero;

class fightController{

    public function __construct($container){
        $this->container = $container;
    }

    public function Index($request, $response){
        var_dump($request->getParsedBody());

        $this->container->view->render($response, 'fight/fight.html.twig');
    }

}