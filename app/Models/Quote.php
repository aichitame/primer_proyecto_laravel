<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $fillable = ['user_id', 'status', 'subtotal', 'discount_total', 'tax_total', 'total'];

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

public function scopeStatus($query, $status){
    return $query->where('status', $status);
}

public function recalcTotals(): void{
    $lines = $this->relationLoaded('lines') ? $this->lines: $this->lines()->get();

    $this->subtotal = $lines->sum('subtotal');
    $this->discount_total = $lines->sum('discount_amount');
    $this->tax_total = $lines->sum('tax_amount');
    $this->total = $lines->sum('total');

    $this->save();
}

}