<?php

namespace dawa\controllers;

class userController{

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