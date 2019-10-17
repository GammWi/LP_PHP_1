<?php
namespace dawa\models;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pictures extends \Illuminate\Database\Eloquent\Model {
    protected $table = "pictures";
    protected $primaryKey = "id_picture";
    public $timestamps = false;

}