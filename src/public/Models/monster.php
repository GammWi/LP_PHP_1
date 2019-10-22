<?php
namespace dawa\models;
use Illuminate\Database\Eloquent\SoftDeletes;

class Monster extends \Illuminate\Database\Eloquent\Model {
    protected $table = "monster";
    protected $primaryKey = "id_monster";
    public $timestamps = false;

    public function character() {
        return $this->belongsTo('\dawa\modele\race','id_character');
    }
}