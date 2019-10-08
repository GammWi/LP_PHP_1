<?php
/**
 * Created by PhpStorm.
 * User: Lucas
 * Date: 01/10/2019
 * Time: 11:11
 */

namespace dawa\Controllers;


class characterController
{
    public function __construct($container){
        $this->container = $container;
    }

    public function Index($request, $response){
        $this->container->view->render($response, 'character/character.html.twig');
    }


}