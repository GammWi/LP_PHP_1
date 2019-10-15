<?php
namespace dawa\models;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pictures extends \Illuminate\Database\Eloquent\Model {
    protected $table = "images";
    protected $primaryKey = "id_img";
    public $timestamps = false;

}