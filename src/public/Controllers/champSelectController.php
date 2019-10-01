<?php

namespace dawa\controllers;

class champSelectController{

    public function __construct($container){
        $this->container = $container;
    }

    public function Index($request, $response){
        $this->container->view->render($response, 'championSelect/affichage.html.twig');
    }

}