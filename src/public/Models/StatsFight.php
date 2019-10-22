<?php
namespace dawa\models;

use Illuminate\Database\Eloquent\SoftDeletes;

class StatsFight extends \Illuminate\Database\Eloquent\Model {

    protected $table = "statsfight";
    protected $primaryKey = "id_stats";
    public $timestamps = false;


}