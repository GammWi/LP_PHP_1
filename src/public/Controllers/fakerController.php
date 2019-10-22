<?php

namespace dawa\controllers;

use Faker\Factory as FakeFactory;
use dawa\models\StatsFight;
use dawa\models\Hero;
use dawa\models\Monster;

class fakerController{

    public function generationCombats(){

        try {
            $faker = FakeFactory::create();
            for($i = 0; $i<250; $i++){
                $fight = new StatsFight();
                $monstre = Monster::all()->random();
                $hero = Hero::all()->random();
                $comnbattants = [$monstre, $hero];
                $winner = array_rand($comnbattants);
                var_dump($winner);
                

            }
        } catch (\Throwable $th) {
            
        }
    }
}