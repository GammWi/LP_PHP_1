<?php

namespace dawa\controllers;

use Slim\Slim;
use dawa\models\Hero as Hero;

class fightController{

    public function __construct($container){
        $this->container = $container;
    }

    public function Index($request, $response){
        $hero = Hero::get();

        $body = $request->getParsedBody();

        $body['heros'] = $hero;
        $body['monstres'] = [['name'=>'Michel'], ['name'=>'Jean']];

        $this->container->view->render($response, 'fight/fight.html.twig', ['heros'=>$body['heros'], 'monstres'=>$body['monstres']]);

       var_dump($_POST['select']);

    }



}

