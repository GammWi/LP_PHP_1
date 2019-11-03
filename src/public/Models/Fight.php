<?php
namespace dawa\models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Fight extends \Illuminate\Database\Eloquent\Model {

    protected $table = "fight";
    protected $primaryKey = "id_fight";
    public $timestamps = true;
    const UPDATED_AT = null;
    protected $fillable = ['id_fight', 'id_hero', 'id_monster'];

    public function hero() {
        return $this->belongsToMany('dawa\models\Hero');

    }

    public function monster() {
        return $this->belongsToMany('dawa\models\Monster');

    }

}