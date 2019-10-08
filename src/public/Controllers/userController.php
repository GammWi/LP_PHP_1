<?php

namespace dawa\controllers;
use dawa\models\User;

class userController{
    
    public function __construct($container){
        $this->container = $container;
    }

    public function signIn($request, $response){
        $this->container->view->render($response, 'user/connection.html.twig');
    }

    public function postSignIn($request, $response){
        $auth = $this->attempt(
            $request->getParam('identifiant'),
            $request->getParam('mdp')
        );
        if(!$auth){
            
            return $response->withRedirect($this->container->router->pathFor('auth.signin'));
        }
        return $response->withRedirect($this->container->router->pathFor('home'));
    }


    public function attempt($pseudo, $mdp){
        $user = User::where('username', $pseudo)->first();
        if(!$user){
            return false;
        }

        if(password_verify($mdp, $user->password)){
            $_SESSION['user'] = $user->id_user;
            return true;
        }

        return false;
    }

    public function check(){
        return isset($_SESSION['user']);

    }

    public function admin(){
        return User::find($_SESSION['user']);
    }

    public function ajouterAdmin($username, $password){
        $u = User::where('username', '=', $username);
        //if($u existe pas)
        $user = new User();
        $user->username = $username;
        $user->password = password_hash('test', PASSWORD_DEFAULT, ["cost" => 10]);
        $user->save();
    }

}