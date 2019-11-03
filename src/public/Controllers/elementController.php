<?php
/**
 * Created by PhpStorm.
 * User: Lucas
 * Date: 17/10/2019
 * Time: 11:26
 */

namespace dawa\Controllers;


use dawa\models\isStrongerElem;

class elementController
{

    public static function isStronger($id1, $id2) {
        $isStronger = isStrongerElem::where("id_elem_stronger", "=", $id1)->where('id_elem_weaker', '=', $id2)->get();
        return !$isStronger->isEmpty();
    }
}




