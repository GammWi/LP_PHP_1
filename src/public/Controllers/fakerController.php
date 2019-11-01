<?php

namespace dawa\controllers;

use Faker\Factory as FakeFactory;
use dawa\models\StatsFight;
use dawa\models\Hero;
use dawa\models\Monster;
use dawa\controllers\fightController;
use dawa\controllers\statsController;

class fakerController{

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function generationCombats($request, $response){
        $fight = new FightController($this->container);
        for($i = 0; $i<250; $i++){
            $monstre = Monster::all()->random();
            $hero = Hero::all()->random();
            $fight->lancerCombat($hero->id_hero, $monstre->id_monster);
        }

        $this->container->flash->addMessage('success', '250 combats viennent d\' être générés');
        return $response->withRedirect($this->container->router->pathFor('home'));
        
    }
}