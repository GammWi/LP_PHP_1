<?php
namespace dawa\controllers;
use dawa\models\Character;
use dawa\models\Element;
use dawa\models\Hero;
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

        $elem = $_POST["namelem"];
        $idElem = Element::where('name','=',$elem)->get();
        $character->id_character_elem = $idElem[0]["id_element"];

        $race = $_POST["namerace"];
        $idRace = race::where('name','=',$race)->get("id_race");
        $character->id_character_race = $idRace[0]["id_race"];

        $character->picture  = $_POST["urlimage"];
        $character->save();


        $hero = new Hero();
        $hero->firstname = $_POST["firstname"];
        $idChara = Character::where("name", "=", $_POST["name"],"and","id_race","=",$idRace[0]["id_race"])->get();
        $hero->id_character = $idChara[0]["id_character"];
        $hero->save();

        return $response->withRedirect($this->container->router->pathFor('home'));


    }

    public function getModifierHero($request, $response){
        $hero = Hero::where('id_hero', $request->getParam('modifier'))->first();
        $charac = Character::where('id_character', $hero->id_character)->first();
        return $this->container->view->render($response, 'character/modifierHero.twig', ['hero' => $hero, 'charact' => $charac]);
    }

    public function postModifierHero($request, $response){

    }

    public function supprimerHero($request, $response){
        $idHero = $_POST['supprimer'];
        $hero = Hero::where('id_hero', '=', $idHero)->get()->each->delete();
        $cha = Character::where('id_character','=', $hero[0]["id_character"])->get()->each->delete();

        return $response->withRedirect($this->container->router->pathFor('home'));

    }

}