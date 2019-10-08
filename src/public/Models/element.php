<?php
namespace dawa\models;
class Element extends \Illuminate\Database\Eloquent\Model {
    protected $table = "element";
    protected $primaryKey = "id_element";
    public $timestamps = false;
    protected $fillable = ['name', "description"];

}