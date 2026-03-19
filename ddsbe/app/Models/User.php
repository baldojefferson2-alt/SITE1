<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users1';
    
// column sa table
    protected $fillable = 
        ['username', 'password', 'gender'];

    protected $hidden =
        ['password',];
    
    public $timestamps = false;
}