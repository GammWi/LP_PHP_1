<?php

namespace dawa\controllers;

use Faker\Factory as FakeFactory;
use dawa\models\StatsFight;
use dawa\models\Hero;
use dawa\models\Monster;
use dawa\controllers\fightController;

class fakerController{

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function generationCombats(){
        
        for($i = 0; $i<250; $i++){
            $monstre = Monster::all()->random();
            $hero = Hero::all()->random();
            $fight = new FightController($this->container);
            $fight->lancerCombat($hero->id_hero, $monstre->id_monster);
        }
        $test = new FightController($this->container);
        $test->statsCharac();
        
    }
}