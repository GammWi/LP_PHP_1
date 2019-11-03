<?php

namespace dawa\controllers;

use dawa\models\StatsFight;
use dawa\models\StatsCharac;
use dawa\models\Character;


class classement
{

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function getClassement($request, $response){
        
        $statsCharac = StatsCharac::orderBy('nbWin', 'DESC')->get();
        
        return $this->container->view->render($response, 'stats/classement.twig', ['characters'=>$statsCharac]);
    }

}