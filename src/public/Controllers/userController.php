<?php

namespace dawa\controllers;
use dawa\models\User;

class userController{
    
    //Constructeur
    public function __construct($container){
        $this->container = $container;
    }

    //Renvoie la page avec le formulaire pour se connecter
    public function signIn($request, $response){
        
        $this->container->view->render($response, 'user/connection.html.twig');
    }

    /*
    * Methode qui permet de vérifier si le couple username/password est OK
    * Retourne false si l'user n'existe pas ou si le couple n'est pas bon
    * Retourne true si le couple user/pass est bon et affecte l'id à une session
    */
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

    /*
    * Permet d'effectuer la connexion
    * Si la connexion est réussi, affiche un message flash et retourne sur la page home
    * Sinon, retourne sur la page de connexion avec un message d'erreur
    */

    public function postSignIn($request, $response){
        $auth = $this->attempt(
            $request->getParam('identifiant'),
            $request->getParam('mdp')
        );
        if(!$auth){
            $this->container->flash->addMessage('error', 'Le couple Username/Password n\'est pas correct !');
            return $response->withRedirect($this->container->router->pathFor('auth.signin'));
        }
        $this->container->flash->addMessage('success', 'Vous êtes connecté !');
        return $response->withRedirect($this->container->router->pathFor('home'));
    }


    
    // Permet de vérifier si l'utilisateur est connecté
    public function check(){
        return isset($_SESSION['user']);

    }

    // Permet de trouver l'utilisateur et donc d'accéder à ses attributs
    public function admin(){
        return User::find($_SESSION['user']);
    }

    //Methode qui permet de se déconnecter 
    public function signOut($request, $response){
        session_destroy();
        $this->container->flash->addMessage('info', 'Vous venez de vous déconnecter');
        return $response->withRedirect($this->container->router->pathFor('home'));
    }


    // Permet d'accéder au panel admin en affichant la liste des comptes admin
    public function panel($request, $response){
        $listeUser = User::all();
        return $this->container->view->render($response, 'user/panel.twig', ['admins'=>$listeUser]);
    }

    public function ajouterAdmin($request, $response){
        $this->container->view->render($response, 'user/add.twig');
    }

    public function postAjouterAdmin($request, $response){
        User::create([
            'username' => $request->getParam('identifiant'),
            'password' => password_hash($request->getParam('mdp'), PASSWORD_DEFAULT, ["cost" => 10])
        ]);
        $this->container->flash->addMessage('success', 'Le compte admin est crée');
        return $response->withRedirect($this->container->router->pathFor('admin.panel'));

    }


    public function postSupprimerAdmin($request, $response){
        $idAdmin = $_POST['suppAdmin'];
        $admin = User::where('id_user', $idAdmin)->first();
        if($this->container->auth->admin() == $admin){
            $this->signOut($request, $response);
        }else{
            $this->container->flash->addMessage('success', 'Le compte est supprimé');
        }
        $admin->delete();
        return $response->withRedirect($this->container->router->pathFor('admin.panel'));
        
    }

    public function getResetPassword($request, $response){
        $this->container->view->render($response, 'user/reset.twig');
    }

    public function verificationPassword($oldPass, $newPass, $confirmPass){
        $adminPass = $this->container->auth->admin()->password;
        if(password_verify($oldPass, $adminPass)){
            if($newPass === $confirmPass){
                return true;
            }else{
                $this->container->flash->addMessage('error', 'Le nouveau mot de passe et la confirmation ne sont pas identiques');
            }
        }else{
            $this->container->flash->addMessage('error', 'Le password actuel saisi n\'nest pas correct');
        }
        
        return false;

    }

    public function postResetPassword($request, $response){
        $confirmation = $this->verificationPassword(
            $request->getParam('passwordOld'),
            $request->getParam('passwordNew1'),
            $request->getParam('passwordNew2')
        );

        if(!$confirmation){
           return $response->withRedirect($this->container->router->pathFor('auth.reset'));
        }
        $user = $this->container->auth->admin();
        $user->update(['password' => password_hash($request->getParam('passwordNew1'), PASSWORD_DEFAULT, ["cost" => 10])]);
        $this->container->flash->addMessage('success', 'Votre mot de passe à bien été changé ! Il sera effectif à votre prochaine connexion');
        return $response->withRedirect($this->container->router->pathFor('admin.panel'));
    }

}