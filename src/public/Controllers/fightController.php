<?php

namespace dawa\controllers;

use Slim\Slim;
use dawa\models\Hero as Hero;

class fightController{

    public function __construct($container){
        $this->container = $container;
    }

    public function Index($request, $response){

        $body = $request->getParsedBody();

        $body['heros'] = [['firstname' => 'Roger']];
        $body['monstres'] = [['name'=>'Michel'], ['name'=>'Jean']];



        $this->container->view->render($response, 'fight/fight.html.twig', ['heros'=>$body['heros'], 'monstres'=>$body['monstres']]);

        var_dump($request->getParam('id_hero'));
        var_dump($_GET['id_monster']);

    }



}

