<?php
namespace dawa\models;

class Character extends \Illuminate\Database\Eloquent\Model {
    protected $table = "character";
    protected $primaryKey = "id_character";
    public $timestamps = false;

    public function race() {
        return $this->belongsTo('\dawa\modele\race','id_character_race');
    }

    public function hero() {
        return $this->hasMany('\dawa\modele\hero', 'id_character','id_character');

    }

    public function monster() {
        return $this->hasMany('\dawa\modele\monster', 'id_character','id_character');

    }


}