<?php
/**
 * Created by PhpStorm.
 * User: Lucas
 * Date: 01/10/2019
 * Time: 10:55
 */

namespace dawa\models;
class race extends \Illuminate\Database\Eloquent\Model {
    protected $table = "race";
    protected $primaryKey = "id_race";
    public $timestamps = false;
}