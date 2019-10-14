<?php

namespace dawa\controllers;

use dawa\models\Character;
use Slim\Slim;
use dawa\models\Hero as Hero;
use dawa\models\Monster as Monster;

class champSelectController{

    public function __construct($container){
        $this->container = $container;
    }

    public function Index($request, $response){
        $hero = Hero::first()
            ->leftJoin('character','character.id_character', '=', 'hero.id_character')
            ->get();

        $monster = Monster::first()
            ->leftJoin('character','character.id_character', '=', 'monster.id_character')
            ->get();

        $this->container->view->render($response, 'championSelect/affichage.html.twig',['hero'=>$hero,'monster'=>$monster]);

    }
}

