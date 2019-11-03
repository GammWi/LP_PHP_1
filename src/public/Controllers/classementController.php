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
        $char = array();
        foreach($statsCharac as $charac){
            $c = Character::where('id_character', $charac->id_charac)->first();
            $hero = Hero::where('id_character', $charac->id_charac)->first();
            if($hero == NULL){
                $char[] = ['firstname' => '']; 
            }else{
                $char[] = ['firstname' =>$hero['firstname']];
            }
            $char[] = ['name' => $c['name']];
        }
        
        return $this->container->view->render($response, 'stats/classement.twig', ['characters'=>$statsCharac, 'c'=>$char]);
    }


}