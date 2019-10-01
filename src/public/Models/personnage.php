<?php
namespace dawa\modele;

class Personnage extends \Illuminate\Database\Eloquent\Model {
    protected $table = "characterController";
    protected $primaryKey = "id_character";
    public $timestamps = false;

    public function race() {
        return $this->belongsTo('\dawa\modele\race','id_character_race');
    }

    public function hero() {
        return $this->hasMany('\dawa\modele\hero', 'id_character','id_character');

    }


}