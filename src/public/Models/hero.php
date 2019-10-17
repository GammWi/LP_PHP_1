<?php
namespace dawa\models;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hero extends \Illuminate\Database\Eloquent\Model {
    protected $table = "hero";
    protected $primaryKey = "id_hero";
    public $timestamps = false;
    protected $fillable = ['firstname'];


    public function character() {
        return $this->belongsTo('\dawa\models\character','id_character');
    }
}