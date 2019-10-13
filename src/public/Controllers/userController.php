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
            $this->container->flash->addMessage('error', 'Le couple Username/Password n\'est pas correct !');
            return $response->withRedirect($this->container->router->pathFor('auth.signin'));
        }
        $this->container->flash->addMessage('info', 'Vous êtes connecté !');
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

    public function signOut($request, $response){
        session_destroy();
        $this->container->flash->addMessage('info', 'Vous venez de vous déconnecter');
        return $response->withRedirect($this->container->router->pathFor('home'));
    }

    public function panel($request, $response){
        return $this->container->view->render($response, 'user/panel.twig');
    }

    public function ajouterAdmin($request, $response){
        $this->container->view->render($response, 'user/add.twig');
    }

    public function postAjouterAdmin($request, $response){
        User::create([
            'username' => $request->getParam('identifiant'),
            'password' => password_hash($request->getParam('mdp'), PASSWORD_DEFAULT, ["cost" => 10])
        ]);
        $this->container->flash->addMessage('info', 'Le compte admin est crée');
        return $response->withRedirect($this->container->router->pathFor('admin.panel'));

    }

    public function postSdeignIn($request, $response){
        $auth = $this->attempt(
            $request->getParam('identifiant'),
            $request->getParam('mdp')
        );
        if(!$auth){
            
            return $response->withRedirect($this->container->router->pathFor('auth.signin'));
        }
        return $response->withRedirect($this->container->router->pathFor('home'));
    }

}