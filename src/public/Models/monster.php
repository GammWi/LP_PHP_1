<?php
namespace dawa\models;
class Monster extends \Illuminate\Database\Eloquent\Model {
    protected $table = "monster";
    protected $primaryKey = "id_monster";
    public $timestamps = false;

    public function character() {
        return $this->belongsTo(Character::class,'id_character');
    }
}