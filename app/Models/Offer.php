<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = ['days_valid', 'priority', 'quantity', 'price', 'condition_id', 'part_id', 'supplier_id'];
}
