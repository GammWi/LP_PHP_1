<?php
namespace dawa\controllers;
use dawa\models\Character;
use dawa\models\Element;
use dawa\models\Hero;
use dawa\models\Images;
use dawa\models\Pictures;
use dawa\models\Race;
use dawa\models\StatsCharac;
use dawa\models\StatsFight;

class heroController{

    public function __construct($container){
        $this->container = $container;
    }

    public function Index($request, $response){
        return $this->container->view->render($response, 'character/hero.html.twig');

    }

    /**
     * @param $request
     * @param $response
     * @return mixed
     * methode app lors de la création d'un héro
     */
    public function CreerHero($request, $response){

        $listeElem = Element::all();
        $listeRace = Race::all();
        foreach ($listeRace as $race) {

            $p = Pictures::where("id_picture", "=", $race["id_picture"])->get();
            $race["path"] = $p[0]["path"];

        }

        return $this->container->view->render($response, 'character/hero.html.twig', ['element'=>$listeElem, 'listerace'=>$listeRace]);

    }

    /**
     * @param $request
     * @param $response
     * @return mixed
     * methode qui permet de gérer l'insertion d'un héro dans la base
     */
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

            $p->name = $newNamePicture;
            $p->path = "../../public/assets/img/characters/".$newNamePicture;
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


    /**
     * @param $request
     * @param $response
     * @return mixed
     * methode app lorsque que l'on souhaite modifier un heros
     */
    public function getModifierHero($request, $response){
        $hero = $this->getAllCaracHero($request->getParam('modifier'));
        $listeElem = Element::where('id_element', '!=', $hero['charac']->id_character_elem)->get();
        $listeRace = Race::where('id_race', '!=', $hero['charac']->id_character_race)->get();
        $p = Pictures::where("id_picture", "=", $hero["charac"]["picture"])->get();
        $hero["hero"]["path"] = $p[0]["path"];
        return $this->container->view->render($response, 'character/modifierHero.twig', ['hero' => $hero, 'listeElem' => $listeElem, 'listeRace' => $listeRace]);
    }

    /**
     * @param $request
     * @param $response
     * @return mixed
     * methode qui permet de traiter la modification d'un heros
     */
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


        $cheminDest = __DIR__;
        $cheminDest = str_replace( "\\","/", $cheminDest);
        $cheminDest = str_replace("Controllers", "assets/img/characters/", $cheminDest);
        $typePicture = str_replace("image/","",$_FILES["img"]["type"]);
        if($typePicture == 'png' || $typePicture == 'gif' || $typePicture == 'jpg' || $typePicture == 'jpeg') {

            $cheminDest = __DIR__;
            $cheminDest = str_replace( "\\","/", $cheminDest);
            $cheminDest = str_replace("Controllers", "assets/img/characters/", $cheminDest);
            $pic = Pictures::where('id_picture', "=", $hero["charac"]["picture"])->get()->each->delete();
            unlink($cheminDest.$pic[0]["name"]);

            $newNamePicture = $hero["charac"]["name"].".".$typePicture;
            move_uploaded_file($_FILES["img"]["tmp_name"], $cheminDest . $newNamePicture);

            $p = new Pictures();
            $p->name = $newNamePicture;
            $p->path = "../../public/assets/img/characters/" . $newNamePicture;
            $p->save();

            $img = Pictures::where("name", "=", $newNamePicture)->first();
            $id_img = $img["id_picture"];

            $hero['charac']->picture = $id_img;
            $hero['charac']->save();

        }


        $hero['hero']->update(['firstname' => $firstname]);

        $this->container->flash->addMessage('info', 'Le Héro '.$firstname.' '.$name.' a bien été modifié');
        return $response->withRedirect($this->container->router->pathFor('home'));
    }

    /**
     * @param $request
     * @param $response
     * @return mixed
     * methode de supression des heros
     */
    public function supprimerHero($request, $response){
        $idHero = $_POST['supprimer'];
        $hero = Hero::where('id_hero', '=', $idHero)->get()->each->delete();
        $cha = Character::where('id_character','=', $hero[0]["id_character"])->get()->each->delete();
        $pic = Pictures::where('id_picture', "=", $cha[0]["picture"])->get()->each->delete();
        $stats = StatsCharac::where('id_charac', $hero[0]["id_character"])->get()->each->delete();

        $cheminDest = __DIR__;
        $cheminDest = str_replace( "\\","/", $cheminDest);
        $cheminDest = str_replace("Controllers", "assets/img/characters/", $cheminDest);
        unlink($cheminDest.$pic[0]["name"]);


        $this->container->flash->addMessage('success', 'Le hero a bien été supprimé');
        return $response->withRedirect($this->container->router->pathFor('home'));
    }

    /**
     * @param $id
     * @return array
     * methode qui permet de retourner tous les heros
     */
    public function getAllCaracHero($id){
        $hero = Hero::where('id_hero', $id)->first();
        $charac = Character::where('id_character', $hero->id_character)->first();
        $elem_hero = Element::where('id_element', $charac->id_character_elem)->first();
        $race_hero = Race::where('id_race', $charac->id_character_race)->first();
        $statsCombat = StatsCharac::where('id_charac', $hero->id_character)->first();
        if($statsCombat['nbTotal'] != 0){
            $pourcentageWin = ($statsCombat['nbWin']/$statsCombat['nbTotal']) * 100;
        }else{
            $pourcentageWin = 0;
        }
        
        $nbWin = $statsCombat['nbWin'];
        $nbLoose = $statsCombat['nbLoose'];
        $nbTotal = $statsCombat['nbTotal'];
        $dmgInfliges = StatsFight::where('id_character', $hero->id_character)->sum('dmgInfliges');
        $dmgRecus = StatsFight::where('id_character', $hero->id_character)->sum('dmgRecus');

        $liste = array('hero' => $hero, 'charac' => $charac, 'elem' => $elem_hero, 
        'race' => $race_hero, 'pourcentage' => $pourcentageWin, 'dmg' => $dmgInfliges, 'dmgTook' => $dmgRecus, 
        'nbWin'=>$nbWin, 'nbLoose'=>$nbLoose, 'nbTotal' => $nbTotal);
        return $liste;
    }

    

}