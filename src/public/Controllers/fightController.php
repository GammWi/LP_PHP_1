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

        function array_clone($array)
        {
            return array_map(function ($element) {
                return ((is_array($element))
                    ? array_clone($element)
                    : ((is_object($element))
                        ? clone $element
                        : $element
                    )
                );
            }, $array);
        }

        function attaque($attaque, $victime)
        {
            $hpLogBefore = $attaque['name'] . ': ' . $attaque['race']['hp'] . 'hp ||| ' . $victime['name'] . ': ' . $victime['race']['hp'] . 'hp';

            $crit = ($attaque['race']['agility'] >= 2 * $victime['race']['agility']);
            $dmg = ($crit) ? $attaque['race']['attack'] * 2 : $attaque['race']['attack'];

            $def = rand(0, 100 - $victime['race']['defense']);
            $dmgDef = 0;
            $tfPercent = 100 - $victime['race']['defense'] * 0.25;
            $fiftyPercent = 100 - $victime['race']['defense'] * 0.50;
            $sfPercent = 100 - $victime['race']['defense'] * 0.75;
            $hundredDef = 100 - $victime['race']['defense'];
            $fullDef = false;
            if (0 < $def && $def <= $tfPercent) {
                $dmgDef = $dmg * 0.90;
            } else {
                if ($tfPercent < $def && $def <= $fiftyPercent) {
                    $dmgDef = $dmg * 0.80;
                } else if ($fiftyPercent < $def && $def <= $sfPercent) {
                    $dmgDef = $dmg * 0.70;
                } else if ($sfPercent < $def && $def < $hundredDef) {
                    $dmgDef = $dmg * 0.60;
                } else if ($def === $hundredDef) {
                    $fullDef = true;
                    $dmgDef = $dmg;
                }
            }

            $dmgLog = $attaque['name'] . ' attaque ' . $victime['name'] . ' pour ' . $dmg;
            $dmgLog .= ($crit) ? ' COUP CRITIQUE !' : '';
            $defLog = $victime['name'] . ' se défend pour ' . $dmgDef;
            $defLog .= ($fullDef) ? ' DEFENSE PARFAITE ' : '';

            $victime['race']['hp'] -= ($dmg - $dmgDef);

            $hpLogAfter = $attaque['name'] . ': ' . $attaque['race']['hp'] . 'hp ||| ' . $victime['name'] . ': ' . $victime['race']['hp'] . 'hp';

            $log = [
                "hpLogBeforeV" => $hpLogBefore,
                "dmgLogV" => $dmgLog,
                "defLogV" => $defLog,
                "hpLogAfterV" => $hpLogAfter
            ];
            return $log;
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

        $attaque = ($leHero['race']['agility'] > $leMonster['race']['agility']) ? $leHero : $leMonster;
        $victime = ($leHero['race']['agility'] > $leMonster['race']['agility']) ? $leMonster : $leHero;

//        $persos = [$leHero, $leMonster];
        $tours = [];
        $tour = 1;
        $log = [];
//        $i = $whostart;
//        $j = ($whostart == 1) ? 0 : 1;
        while (!$fin) {
            if ($attaque['race']['hp'] > 0 && $victime['race']['hp'] > 0) {
                $logAttaque = attaque($attaque, $victime);
                $log = [
                    'tour' => $tour,
                    'win' => false,
                    'hpLogBefore' => $logAttaque['hpLogBeforeV'],
                    'dmgLog' => $logAttaque['dmgLogV'],
                    'defLog' => $logAttaque['defLogV'],
                    'hpLogAfter' => $logAttaque['hpLogAfterV']
                ];
                if ($attaque['race']['hp'] > 0 && $victime['race']['hp'] > 0) {
                    $tmp = $attaque;
                    $attaque = $victime;
                    $victime = $tmp;
                }
            } else {
                $log = [
                    'tour' => 'FIN',
                    'win' => true,
                    'winner' => $attaque,
                    'looser' => $victime
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
            "tours" => $tours,
            "winner" => $attaque
        ]]);
    }


}

