<?php
namespace dawa\modele;

class personnage extends \Illuminate\Database\Eloquent\Model {
    protected $table = "character";
    protected $primaryKey = "id_character";
    public $timestamps = false;

    public function race() {
        return
    }
}