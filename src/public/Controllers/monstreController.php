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
        $listeRace = Race::all();
        return $this->container->view->render($response, 'character/monster.html.twig', ['element'=>$listeElem, 'listerace'=>$listeRace]);

    }

    public function insererMonster($request, $response) {
        $character = new Character();

        $character->name = $_POST["name"];

        $elem = $_POST["namelem"];
        $idElem = Element::where('name','=',$elem)->get();
        $character->id_character_elem = $idElem[0]["id_element"];

        $race = $_POST["namerace"];
        $idRace = Race::where('name','=',$race)->get("id_race");
        $character->id_character_race = $idRace[0]["id_race"];


        $cheminDest = "../../public/assets/img/characters/";

        move_uploaded_file($_FILES["img"]["tmp_name"], $cheminDest.$_FILES["img"]["name"]);
        $p = new Pictures();
        $p->name = $_FILES["img"]["name"];
        $p->path = $cheminDest;
        $p->save();

        $id_img = Pictures::where("name","=",$_FILES["img"]["name"])->first();
        $character->picture = $id_img["id_picture"];
        $character->save();


        $monster = new Monster();
        $idChara = Character::where("name", "=", $_POST["name"],"and","id_race","=",$idRace[0]["id_race"])->get();
        $monster->id_character = $idChara[0]["id_character"];
        $monster->save();

        return $response->withRedirect($this->container->router->pathFor('home'));


    }

    public function getModifierMonster($request, $response){
        $monstre = $this->getAllCaracMonstre($request->getParam('modifier'));
        $listeElem = Element::where('id_element', '!=', $monstre['charac']->id_character_elem)->get();
        $listeRace = Race::where('id_race', '!=', $monstre['charac']->id_character_race)->get();
        
        return $this->container->view->render($response, 'character/modifierMonstre.twig', ['monstre' => $monstre, 'listeElem' => $listeElem, 'listeRace' => $listeRace]);
    }

    public function postModifierMonster($request, $response){
        $monstre = $this->getAllCaracMonstre($request->getParam('id_monstre'));
        $newRace = $request->getParam('race');
        $newElem = $request->getParam('elem');
        $name = $request->getParam('name');

        if($newRace !== $monstre['race']->name){
            $idRace = Race::where('name','=',$newRace)->first();
            $monstre['charac']->update(['id_character_race' => $idRace['id_race']]);
        }if($newElem !== $monstre['elem']->name){
            $idElem = Element::where('name','=',$newElem)->first();
            $monstre['charac']
                ->update(['id_character_elem' => $idElem['id_element'], 
                          'name' => $name]);
        }else{
            $monstre['charac']->update(['name' => $name]);
        }
        
        $this->container->flash->addMessage('info', 'Le monstre '.$name.' a bien été modifié');
        return $response->withRedirect($this->container->router->pathFor('home'));
    }

    public function supprimerMonster($request, $response){
        $idMonstre = $_POST['supprimer'];
        $monstre = Monster::where('id_monster', '=', $idMonstre)->get()->each->delete();
        $cha = Character::where('id_character','=', $monstre[0]["id_character"])->get()->each->delete();
        $this->container->flash->addMessage('success', 'Le monstre a bien été supprimé');
        return $response->withRedirect($this->container->router->pathFor('home'));
    }
    

    public function getAllCaracMonstre($id){
        $monstre = Monster::where('id_monster', $id)->first();
        $charac = Character::where('id_character', $monstre->id_character)->first();
        $elem_monstre = Element::where('id_element', $charac->id_character_elem)->first();
        $race_monstre = Race::where('id_race', $charac->id_character_race)->first();

        $liste = array('monstre' => $monstre, 'charac' => $charac, 'elem' => $elem_monstre, 'race' => $race_monstre);
        return $liste;
    }

}