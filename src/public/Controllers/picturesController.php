<?php
/**
 * Created by PhpStorm.
 * User: Lucas
 * Date: 17/10/2019
 * Time: 11:26
 */

namespace dawa\Controllers;


use dawa\models\Pictures;

class picturesController
{

    public function getImageUrl($id) {
        $picture = Pictures::where("id_picture", "=", $id)->get();
        return $picture;
    }
}




