<?php
global $BASE_URL;
$config=array();
$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;
$config['db'] = [
    'default'   => 'mysql',
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'dawa',
    'username'  => 'root',
    'password'  => '',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci'
];
