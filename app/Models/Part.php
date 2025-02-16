<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    protected $fillable = ['supplier_id', 'days_valid', 'priority', 'part_number', 'part_desc', 'quantity', 'price', 'condition_id', 'category_id'];


    public function supplier() {
        return $this->belongsTo(Supplier::class);
    }


    public function condition() {
        return $this->belongsTo(Condition::class);
    }


    public function category() {
        return $this->belongsTo(Category::class);
    }
}