<?php
namespace dawa\controllers;

class heroController{

    public function Index($request, $response){
        $this->container->view->render($response, 'character/hero.html.twig');
    }

}