<?php

namespace dawa\controllers;

use dawa\models\Character;
use dawa\models\Element;
use dawa\models\Hero as Hero;
use dawa\models\Monster;
use dawa\models\Race;
use Slim\Slim;

class fightController
{

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function Index($request, $response)
    {
        $idMonster = $_GET['id_monster'];
        $idHero = $_GET['id_hero'];

        $hero = Hero::where('id_hero', '=', $idHero)->first();
        $characHero = Character::where('id_character', '=', $hero['id_character'])->first();
        $raceHero = Race::where('id_race', '=', $characHero['id_character_race'])->first();
        $elemHero = Element::where('id_element', '=', $hero['id_character_elem'])->first();

        $monster = Monster::where('id_monster', '=', $idMonster)->first();
        $characMonster = Character::where('id_character', '=', $monster['id_character'])->first();
        $raceMonster = Race::where('id_race', '=', $characMonster['id_character_race'])->first();
        $elemMonster = Element::where('id_element', '=', $monster['id_character_elem'])->first();

        $leHero = [
            'hero' => $hero->getAttributes(),
            'char' => $characHero->getAttributes(),
            'race' => $raceHero,
            'elem' => $elemHero,
            'name' => $hero['firstname'] . ' ' . $characHero['name']
        ];

        $leMonster = [
            'monster' => $monster->getAttributes(),
            'char' => $characMonster->getAttributes(),
            'race' => $raceMonster,
            'elem' => $elemMonster,
            'name' => $characMonster['name']
        ];

        function array_clone($array) {
            return array_map(function($element) {
                return ((is_array($element))
                    ? array_clone($element)
                    : ((is_object($element))
                        ? clone $element
                        : $element
                    )
                );
            }, $array);
        }

        $beforeLeHero = array_clone($leHero);
        $beforeLeMonster = array_clone($leMonster);

        $fin = false;

        $whostart = rand(0, 1);

        function pr($data)
        {
            echo "<pre>";
            echo($data);
            echo "</pre>";
        }

        $persos = [$leHero, $leMonster];
        $tours = [];
        $tour = 1;
        $log = [];
        $i = $whostart;
        $j = ($whostart == 1) ? 0 : 1;
        while (!$fin) {
            if ($persos[0]['race']['hp'] > 0 && $persos[1]['race']['hp'] > 0) {
                $hpLogBefore = $persos[$i]['name'] . ': ' . $persos[$i]['race']['hp'] . 'hp ||| ' . $persos[$j]['name'] . ': ' . $persos[$j]['race']['hp'] . 'hp';
                $dmgLog = $persos[$i]['name'] . ' attaque ' . $persos[$j]['name'] . ' pour ' . $persos[$i]['race']['attack'];
                $persos[$j]['race']['hp'] -= $persos[$i]['race']['attack'];
                $hpLogAfter = $persos[$i]['name'] . ': ' . $persos[$i]['race']['hp'] . 'hp ||| ' . $persos[$j]['name'] . ': ' . $persos[$j]['race']['hp'] . 'hp';
                $log = [
                    'tour' => $tour,
                    'win' => false,
                    'hpLogBefore' => $hpLogBefore,
                    'dmgLog' => $dmgLog,
                    'hpLogAfter' => $hpLogAfter
                ];
                if ($persos[0]['race']['hp'] > 0 && $persos[1]['race']['hp'] > 0) {
                    $tmp = $i;
                    $i = $j;
                    $j = $tmp;
                }
            } else {
                $log = [
                    'tour' => 'FIN',
                    'win' => true,
                    'winner' => $persos[$i],
                    'looser' => $persos[$j]
                ];
                $fin = true;
            }
            $tours[] = [
                "id" => $tour,
                "log" => $log
            ];
            $tour++;
        }

        $this->container->view->render($response, 'fight/fight.html.twig', ['combat' => [
            "persos" => [$beforeLeHero, $beforeLeMonster],
            "nbTours" => $tour,
            "tours" => $tours
        ]]);
    }


}

