<?php
namespace dawa\controllers;
use dawa\models\Character;
use dawa\models\Element;
use dawa\models\Hero;
use dawa\models\Monster;
use dawa\models\Pictures;
use dawa\models\race;

class monstreController{

    public function __construct($container){
        $this->container = $container;
    }

    public function Index($request, $response){
        return $this->container->view->render($response, 'character/monster.html.twig');

    }

    public function CreerMonster($request, $response){

        $listeElem = Element::all();
        $listeRace = race::all();
        return $this->container->view->render($response, 'character/monster.html.twig', ['element'=>$listeElem, 'listerace'=>$listeRace]);

    }

    public function insererMonster($request, $response) {
        $character = new Character();

        $character->name = $_POST["name"];

        $elem = $_POST["namelem"];
        $idElem = Element::where('name','=',$elem)->get();
        $character->id_character_elem = $idElem[0]["id_element"];

        $race = $_POST["namerace"];
        $idRace = race::where('name','=',$race)->get("id_race");
        $character->id_character_race = $idRace[0]["id_race"];

        $character->save();

        $cheminDest = "D:/wamp64/www/LP_PHP_1/src/public/assets/img/characters/";
        move_uploaded_file($_FILES["img"]["tmp_name"], $cheminDest.$_FILES["img"]["name"]);
        $p = new Pictures();
        $p->name = $_FILES["img"]["name"];
        $p->path = $cheminDest;
        $p->save();


        $monster = new Monster();
        $idChara = Character::where("name", "=", $_POST["name"],"and","id_race","=",$idRace[0]["id_race"])->get();
        $monster->id_character = $idChara[0]["id_character"];
        $monster->save();

        return $response->withRedirect($this->container->router->pathFor('home'));


    }

    public function modifierMonster($request, $response){
        echo "L'id du monstre que vous voulez supprimer est : ".$_POST['modifier'];
    }

    public function supprimerMonster($request, $response){
        $idMonstre = $_POST['supprimer'];
        $monstre = Monster::where('id_monster', '=', $idMonstre)->get()->each->delete();
        $cha = Character::where('id_character','=', $monstre[0]["id_character"])->get()->each->delete();

        return $response->withRedirect($this->container->router->pathFor('home'));
    }


}