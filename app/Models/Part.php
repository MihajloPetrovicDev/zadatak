<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    protected $fillable = ['part_number', 'part_desc', 'category_id'];
    

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }
}