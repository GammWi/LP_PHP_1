<?php

namespace dawa\controllers;

use dawa\models\StatsFight;
use dawa\models\Hero;
use dawa\models\Monster;
use dawa\controllers\fightController;

class statsController
{

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function test(){
        //var_dump($this->container->fight->);
    }

}