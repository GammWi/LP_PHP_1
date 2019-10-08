<?php

namespace dawa\models;
use Illuminate\Database\Eloquent\Model;

class User extends Model{

    protected $table = "user";
    protected $fillable = ['username', "password"];

    protected $primaryKey = "id_user";

    public $timestamps = true;
}