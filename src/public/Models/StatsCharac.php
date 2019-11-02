<?php
namespace dawa\models;

use Illuminate\Database\Eloquent\SoftDeletes;

class StatsCharac extends \Illuminate\Database\Eloquent\Model {

    protected $table = "statscharac";
    protected $primaryKey = "id_statscharac";
    public $timestamps = false;
    protected $fillable = ['id_charac', 'type', 'nbWin', 'nbLoose', 'nbTotal'];


}