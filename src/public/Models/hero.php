<?php
namespace dawa\models;
class Hero extends \Illuminate\Database\Eloquent\Model {
    protected $table = "hero";
    protected $primaryKey = "id_hero";
    public $timestamps = false;
    public function character() {
        return $this->belongsTo('\dawa\models\race','id_character');
    }
}