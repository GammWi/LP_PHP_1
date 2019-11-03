<?php

namespace dawa\controllers;

use dawa\models\StatsFight;
use dawa\models\StatsCharac;
use dawa\models\Character;
use dawa\models\Hero;


class classementController
{

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function getClassement($request, $response){
        
        $statsCharac = StatsCharac::orderBy('nbWin', 'DESC')->get();
        $test = array();
        foreach($statsCharac as $charac){
            $c = Character::where('id_character', $charac->id_charac)->first();
            $hero = Hero::where('id_character', $charac->id_charac)->first();
            if($hero == NULL){
                $test[] = ['firstname' => '']; 
            }else{
                $test[] = ['firstname' =>$hero['firstname']];
            }
            $test[] = ['name' => $c['name']];
        }

        var_dump($test);
        
        return $this->container->view->render($response, 'stats/classement.twig', ['characters'=>$statsCharac, 'c'=>$test]);
    }


}