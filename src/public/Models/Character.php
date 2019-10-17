<?php
namespace dawa\models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Character extends \Illuminate\Database\Eloquent\Model {

    protected $table = "character";
    protected $primaryKey = "id_character";
    public $timestamps = false;
    protected $fillable = ['id_character_race', 'id_character_elem', 'name'];

    public function race() {
        return $this->belongsTo('\dawa\modele\race','id_character_race');
    }

    public function hero() {
        return $this->hasMany('\dawa\modele\hero', 'id_character','id_character');

    }

    public function monster() {
        return $this->hasMany('\dawa\modele\monster', 'id_character','id_character');

    }

    public function pictures() {
        return $this->belongsTo('\dawa\models\character','id_picture');
    }


}