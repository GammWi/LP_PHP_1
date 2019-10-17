<?php
namespace dawa\controllers;
use dawa\models\Character;
use dawa\models\Element;
use dawa\models\Hero;
use dawa\models\Images;
use dawa\models\Pictures;
use dawa\models\Race;

class heroController{

    public function __construct($container){
        $this->container = $container;
    }

    public function Index($request, $response){
        return $this->container->view->render($response, 'character/hero.html.twig');

    }

    public function CreerHero($request, $response){

        $listeElem = Element::all();
        $listeRace = Race::all();
        return $this->container->view->render($response, 'character/hero.html.twig', ['element'=>$listeElem, 'listerace'=>$listeRace]);

    }

    public function insererHero($request, $response) {

        $character = new Character();



        $elem = $_POST["namelem"];
        $idElem = Element::where('name','=',$elem)->get();
        $character->id_character_elem = $idElem[0]["id_element"];

        $race = $_POST["namerace"];

        $idRace = race::where('name','=',$race)->get("id_race");
        $character->name = $_POST["name"];

        $character->id_character_race = $idRace[0]["id_race"];



        $cheminDest = "D:/wamp64/www/LP_PHP_1/src/public/assets/img/characters/";
        move_uploaded_file($_FILES["img"]["tmp_name"], $cheminDest.$_FILES["img"]["name"]);
        $p = new Pictures();
        $p->name = $_FILES["img"]["name"];
        $p->path = $cheminDest;
        $p->save();
        $id_img = Pictures::where("name","=",$_FILES["img"]["name"])->first();
        $character->picture = $id_img["id_picture"];
        $character->save();

        $hero = new Hero();
        $hero->firstname = $_POST["firstname"];
        $idChara = Character::where("name", "=", $_POST["name"],"and","id_race","=",$idRace[0]["id_race"])->get();
        $hero->id_character = $idChara[0]["id_character"];
        $hero->save();



        return $response->withRedirect($this->container->router->pathFor('home'));


    }

    public function modifierHero($request, $response){
        echo "L'id du héros que vous voulez supprimer est : ".$_POST['modifier'];


    }

    public function supprimerHero($request, $response){
        $idHero = $_POST['supprimer'];
        $hero = Hero::where('id_hero', '=', $idHero)->get()->each->delete();
        $cha = Character::where('id_character','=', $hero[0]["id_character"])->get()->each->delete();

        return $response->withRedirect($this->container->router->pathFor('home'));

    }

}