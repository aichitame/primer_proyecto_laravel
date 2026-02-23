<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Product extends Model
{

use HasFactory;

protected $fillable = ['name', 'active', 'price', 'tax_rate'];

protected $casts = [
    'active' => 'boolean',
    'price' => 'decimal:2',
    'tax_rate' => 'decimal:2'
];
    public function lines(){
        return $this->hasMany(\App\Models\QuoteLine::class);
    }

public function scopeActivity($query){
    return $query->where('active', true);
}

}