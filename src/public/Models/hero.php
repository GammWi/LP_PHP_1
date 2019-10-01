<?php
namespace dawa\modele;

class Hero extends \Illuminate\Database\Eloquent\Model {
    protected $table = "hero";
    protected $primaryKey = "id_hero";
    public $timestamps = false;

    public function character() {
        return $this->belongsTo('\dawa\modele\race','id_character');
    }


}