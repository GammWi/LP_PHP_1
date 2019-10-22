<?php
/**
 * Created by PhpStorm.
 * User: Lucas
 * Date: 17/10/2019
 * Time: 11:26
 */

namespace dawa\Controllers;


class picturesController
{
    public function __construct($container){
        $this->container = $container;
    }

    public function getImage($request, $response, $id) {
        var_dump($id);
    }
}




