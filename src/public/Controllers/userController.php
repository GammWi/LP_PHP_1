<?php

namespace dawa\controllers;
use dawa\models\User;

class userController{

    public function __construct($container){
        $this->container = $container;
    }

    public function Index($request, $response){
        $this->container->view->render($response, 'user/connection.html.twig');
    }

    public function ajouterAdmin($username, $password){
        $u = User::where('username', '=', $username);
        //if($u existe pas)
        $user = new User();
        $user->username = $username;
        $user->password = password_hash($password, PASSWORD_DEFAULT, ["cost" => 12]);
        $user->save();
    }

    public static function authentification($username, $password){
        $u = User::where('username', '=', $username)->first();
        if(password_verify($password, $u->password)){
            $_SESSION['idUser'] = $u->id;
            $_SESSION['statut'] = 'connected';
            return 0;
        }else{
            $_SESSION['statut'] = 'failed';
            return -1;
        }
    }
}