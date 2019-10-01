<?php

namespace dawa\controllers;

class userController{

    public function __construct($container){
        $this->container = $container;
    }
    
    public function Index($request, $response){
        $this->container->view->render($response, 'test.html.twig');
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