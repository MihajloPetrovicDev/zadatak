<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Condition extends Model
{
    protected $fillable = ['condition_name'];
    

    public $timestamps = false;
}
