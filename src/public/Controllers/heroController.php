<?php
namespace dawa\controllers;
use dawa\models\Character;
use dawa\models\Element;
use dawa\models\race;

class heroController{

    public function __construct($container){
        $this->container = $container;
    }

    public function Index($request, $response){
        return $this->container->view->render($response, 'character/hero.html.twig');

    }

    public function CreerHero($request, $response){

        $listeElem = Element::all();
        $listeRace = race::all();
        return $this->container->view->render($response, 'character/hero.html.twig', ['element'=>$listeElem, 'listerace'=>$listeRace]);

    }

    public function insererHero($request, $response) {

        $character = new Character();
        $character->name = $_POST["name"];
        //$elem = $_POST["namelem"];
        //$idElem = Element::find($elem);
        //$character->

        $race = $_POST["namerace"];

        $idRace = race::where('name','=',$race)->get("id_race");

        $character->id_character_race = $idRace[0]["id_race"];

        $character->picture  = $_POST["urlimage"];


        $character->save();


    }

}