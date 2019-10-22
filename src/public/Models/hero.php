<?php
namespace dawa\models;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hero extends \Illuminate\Database\Eloquent\Model {
    protected $table = "hero";
    protected $primaryKey = "id_hero";
    public $timestamps = false;
    protected $fillable = ['firstname'];


    public function character() {
        return $this->belongsTo(Character::class,'id_character');
    }

    public function test() {
//        var_dump($this->character()->first()->race()->first()->getAttributes());
    }

    public function subirDmg($dmg) {
        $this->character()->first()->race()->first()['hp'] -= $dmg;
    }
}