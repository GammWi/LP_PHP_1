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

        $nameSame = Character::where('name', '=', $_POST["name"])->first();
        if($nameSame == NULL) {
            $character->name = $_POST["name"];
        }else {
            return $response->withRedirect($this->container->router->pathFor('creerHero'));
        }


        $character->id_character_race = $idRace[0]["id_race"];

        $cheminDest = __DIR__;
        $cheminDest = str_replace( "\\","/", $cheminDest);
        $cheminDest = str_replace("Controllers", "assets/img/characters/", $cheminDest);

        $typePicture = str_replace("image/","",$_FILES["img"]["type"]);
        if($typePicture == 'png' || $typePicture == 'gif' || $typePicture == 'jpg' || $typePicture == 'jpeg') {
            $newNamePicture = $_POST["name"].".".$typePicture;
            move_uploaded_file($_FILES["img"]["tmp_name"], $cheminDest.$newNamePicture);
            $p = new Pictures();
            $p->name = $_POST["name"];
            $p->path = "../../public/assets/img/characters/";
            $p->save();
            $id_img = Pictures::where("name","=",$newNamePicture)->first();
            $character->picture = $id_img["id_picture"];
            $character->save();

            $hero = new Hero();
            $hero->firstname = $_POST["firstname"];
            $idChara = Character::where("name", "=", $_POST["name"],"and","id_race","=",$idRace[0]["id_race"])->get();
            $hero->id_character = $idChara[0]["id_character"];
            $hero->save();
        }else {
            $p = new Pictures();
            $p->name = "Erreur";
            $p->path = "/";
            $p->save();
            $id_img = Pictures::where("name","=","Erreur")->first();
            $character->picture = $id_img["id_picture"];
            $character->save();

            $hero = new Hero();
            $hero->firstname = $_POST["firstname"];
            $idChara = Character::where("name", "=", $_POST["name"],"and","id_race","=",$idRace[0]["id_race"])->get();
            $hero->id_character = $idChara[0]["id_character"];
            $hero->save();
        }

        return $response->withRedirect($this->container->router->pathFor('home'));


    }



    public function getModifierHero($request, $response){
        $hero = $this->getAllCaracHero($request->getParam('modifier'));
        $listeElem = Element::where('id_element', '!=', $hero['charac']->id_character_elem)->get();
        $listeRace = Race::where('id_race', '!=', $hero['charac']->id_character_race)->get();
        return $this->container->view->render($response, 'character/modifierHero.twig', ['hero' => $hero, 'listeElem' => $listeElem, 'listeRace' => $listeRace]);
    }


    public function postModifierHero($request, $response){
        $hero = $this->getAllCaracHero($request->getParam('id_hero'));
        $newRace = $request->getParam('race');
        $newElem = $request->getParam('elem');
        $name = $request->getParam('name');
        $firstname = $request->getParam('firstname');

        if($newRace !== $hero['race']->name){
            $idRace = Race::where('name','=',$newRace)->first();
            $hero['charac']->update(['id_character_race' => $idRace['id_race']]);
        }if($newElem !== $hero['elem']->name){
            $idElem = Element::where('name','=',$newElem)->first();
            $hero['charac']
                ->update(['id_character_elem' => $idElem['id_element'], 
                          'name' => $name]);
        }else{
            $hero['charac']->update(['name' => $name]);
        }
 
        $hero['hero']->update(['firstname' => $firstname]);

        $this->container->flash->addMessage('info', 'Le Héro '.$firstname.' '.$name.' a bien été modifié');
        return $response->withRedirect($this->container->router->pathFor('home'));
    }

    public function supprimerHero($request, $response){
        $idHero = $_POST['supprimer'];
        $hero = Hero::where('id_hero', '=', $idHero)->get()->each->delete();
        $cha = Character::where('id_character','=', $hero[0]["id_character"])->get()->each->delete();
        $this->container->flash->addMessage('success', 'Le hero a bien été supprimé');
        return $response->withRedirect($this->container->router->pathFor('home'));
    }

    public function getAllCaracHero($id){
        $hero = Hero::where('id_hero', $id)->first();
        $charac = Character::where('id_character', $hero->id_character)->first();
        $elem_hero = Element::where('id_element', $charac->id_character_elem)->first();
        $race_hero = Race::where('id_race', $charac->id_character_race)->first();

        $liste = array('hero' => $hero, 'charac' => $charac, 'elem' => $elem_hero, 'race' => $race_hero);
        return $liste;
    }

    

}