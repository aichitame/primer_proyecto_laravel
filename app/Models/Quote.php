<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $fillable = ['user_id', 'status', 'subtotal', 'discout_total', 'tax_total', 'total'];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount_total' => 'decimal:2',
        'tax_total' => 'decimal:2',
        'total' => 'decimal:2'
    ];

public function user(){
    return $this->belongsTo(\App\Models\User::class);
}

public function lines(){
    return $this->hasMany(\App\Models\QuoteLine::class);
}

public function recalculateTotal(){
    $this->total = $this->lines->sum('total');

    $this->save();
}

public function scopeStatus($query, $status){
    return $query->where('status', $status);
}
}