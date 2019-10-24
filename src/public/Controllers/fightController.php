<?php

namespace dawa\controllers;

use dawa\models\Character;
use dawa\models\Element;
use dawa\models\Hero as Hero;
use dawa\models\Monster;
use dawa\models\Race;

class fightController
{

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function fight($idHero, $idMonster)
    {
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
            'name' => $hero['firstname'] . ' ' . $characHero['name'],
            'totalDmg' => 0.0,
            'totalDmgTook' => 0.0,
            'type' => 'hero'
        ];

        $leMonster = [
            'monster' => $monster->getAttributes(),
            'char' => $characMonster->getAttributes(),
            'race' => $raceMonster,
            'elem' => $elemMonster,
            'name' => $characMonster['name'],
            'totalDmg' => 0.0,
            'totalDmgTook' => 0.0,
            'type' => 'monster'
        ];

        $beforeLeHero = $this->array_clone_liste($leHero);
        $beforeLeMonster = $this->array_clone_liste($leMonster);

        $fin = false;

        $attaque = ($leHero['race']['agility'] > $leMonster['race']['agility']) ? $leHero : $leMonster;
        $victime = ($leHero['race']['agility'] > $leMonster['race']['agility']) ? $leMonster : $leHero;

        $tours = [];
        $tour = 1;
        $log = [];
        while (!$fin) {
            $resTour = $this->tour($attaque, $victime, $tour);
            $fin = $resTour['fin'];
            $attaque = $resTour['attaque'];
            $victime = $resTour['victime'];
            $tours[] = [
                "id" => $tour,
                "log" => $resTour['log']
            ];
            $tour++;
        }
        return ['combat' => [
            "persos" => [$beforeLeHero, $beforeLeMonster],
            "nbTours" => $tour,
            "tours" => $tours,
            "winner" => $attaque,
            "looser" => $victime
        ]];
    }

    function array_clone_liste($array)
    {
        return array_map(function ($element) {
            return ((is_array($element))
                ? $this->array_clone_liste($element)
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
        $tfPercent = (100 - $victime['race']['defense']) * 0.25;
        $fiftyPercent = (100 - $victime['race']['defense']) * 0.50;
        $sfPercent = (100 - $victime['race']['defense']) * 0.75;
        $hundredDef = (100 - $victime['race']['defense']);
        $fullDef = false;
        if (0 < $def && $def <= $tfPercent) {
            $dmgDef = $dmg * 0.10;
        } else {
            if ($tfPercent < $def && $def <= $fiftyPercent) {
                $dmgDef = $dmg * 0.25;
            } else if ($fiftyPercent < $def && $def <= $sfPercent) {
                $dmgDef = $dmg * 0.33;
            } else if ($sfPercent < $def && $def < $hundredDef) {
                $dmgDef = $dmg * 0.50;
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
            "attaque" => $attaque,
            "hpLogBeforeV" => $hpLogBefore,
            "dmgLogV" => $dmgLog,
            "defLogV" => $defLog,
            "hpLogAfterV" => $hpLogAfter,
            "dmgDealt" => $dmg - $dmgDef,
            "victime" => $victime
        ];
        return $log;
    }

    public function Index($request, $response)
    {
        $idMonster = $_GET['id_monster'];
        $idHero = $_GET['id_hero'];
        $fight = $this->fight($idHero, $idMonster);
        $this->saveLog($fight);
        return $this->container->view->render($response, 'fight/fight.html.twig', $fight);
    }

    public function saveLog($logs)
    {
//         winner, looser, nbPvWinner, nbDmgWinner, nbDmgLooser
        $winner = $logs['combat']['winner'];
        $looser = $logs['combat']['looser'];
        $winnerDmg = $logs['combat']['winner']['totalDmg'];
        $looserDmg = $logs['combat']['looser']['totalDmg'];

    }

    public function tour($attaque, $victime, $tour, $persos = [])
    {
        if ($attaque['race']['hp'] > 0 && $victime['race']['hp'] > 0) {
            $fin = false;
            $logAttaque = $this->attaque($attaque, $victime);
            $attaque['totalDmg'] += $logAttaque['dmgDealt'];
            $victime['totalDmgTook'] += $logAttaque['dmgDealt'];
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
        return ['fin' => $fin, 'attaque' => $attaque, 'victime' => $victime, 'log' => $log];
    }

    public function initFight($request, $response)
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
            'name' => $hero['firstname'] . ' ' . $characHero['name'],
            'totalDmg' => 0.0,
            'totalDmgTook' => 0.0,
            'type' => 'hero'
        ];

        $leMonster = [
            'monster' => $monster->getAttributes(),
            'char' => $characMonster->getAttributes(),
            'race' => $raceMonster,
            'elem' => $elemMonster,
            'name' => $characMonster['name'],
            'totalDmg' => 0.0,
            'totalDmgTook' => 0.0,
            'type' => 'monster'
        ];

        $beforeLeHero = $this->array_clone_liste($leHero);
        $beforeLeMonster = $this->array_clone_liste($leMonster);

        $persos = ["initial" => ["beforeHero" => $beforeLeHero, "beforeMonster" => $beforeLeMonster], "hero" => $leHero, "monster" => $leMonster];
        $combat = ['combat' => [
            "persos" => $persos
        ]];
        var_dump($persos);
        return $this->container->view->render($response, 'fight/initFight.html.twig', $combat);
    }

    public function startFight($request, $response)
    {
        $persos = json_decode($_POST['persos'], true);

        $attaque = ($persos['initial']['beforeHero']['race']['agility'] > $persos['initial']['beforeMonster']['race']['agility']) ? $persos['hero'] : $persos['monster'];
        $victime = ($persos['initial']['beforeHero']['race']['agility'] > $persos['initial']['beforeMonster']['race']['agility']) ? $persos['monster'] : $persos['hero'];

        $tours = [];
        $tour = 1;
        $log = [];
        $fin = false;
            $resTour = $this->tour($attaque, $victime, $tour);
            $fin = $resTour['fin'];
            $attaque = $resTour['attaque'];
            $victime = $resTour['victime'];
            $tours[] = [
                "id" => $tour,
                "log" => $resTour['log']
            ];
            $tour++;
//        }
        $combat = ['combat' => [
            "persos" => [$persos['initial']['beforeHero'], $persos['initial']['beforeMonster']],
            "nbTours" => $tour,
            "tours" => $tours,
            "winner" => $attaque,
            "looser" => $victime,
            "type" => 'tpt'
        ]];
        return $this->container->view->render($response, 'fight/fight.html.twig', $combat);
    }

    function nextTour($request, $response) {

    }

}
