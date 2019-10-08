<?php

namespace dawa\controllers;

use Slim\Slim;
use dawa\models\Hero as Hero;
//use dawa\models\monstre as Monster;

class champSelectController{

    public function __construct($container){
        $this->container = $container;
    }

    public function Index($request, $response){
        $hero = Hero::get();

        //$monster = Monster::get();
        //var_dump($hero);
        $this->container->view->render($response, 'championSelect/affichage.html.twig',['hero'=>$hero]);
    }

}