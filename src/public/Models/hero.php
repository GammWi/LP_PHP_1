<?php
namespace dawa\models;
class Hero extends \Illuminate\Database\Eloquent\Model {
    protected $table = "hero";
    protected $primaryKey = "id_hero";
    public $timestamps = false;
    protected $fillable = ['firstname'];

    public function character() {
        return $this->belongsTo(Character::class,'id_character');
    }


}