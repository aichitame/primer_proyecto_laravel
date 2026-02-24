<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteLine extends Model
{
 /**
     * Eloquent attributes casted as decimal are typically handled as strings.
     * Esto ayuda al IDE/analizador a no inventarse un tipo "decimal" incompatible.
     *
     * @property string|null $unit_price
     * @property string|null $discount_rate
     * @property string|null $tax_rate
     * @property string|null $subtotal
     * @property string|null $discount_amount
     * @property string|null $tax_amount
     * @property string|null $total
     */
    protected $fillable = [
        'quote_id', 'product_id', 'qty',
        'unit_price', 'discount_rate', 'tax_rate',
        'subtotal', 'discount_amount', 'tax_amount', 'total'
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'discount_rate' => 'decimal:2',
        'tax_rate' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total' => 'decimal:2'
    ];

    public function quote(){
        return $this->belongsTo(\App\Models\Quote::class);
    }

    public function product(){
        return $this->belongsTo(\App\Models\Product::class);
    }

    protected static function booted(){
        static::creating(function (QuoteLine $line){
            //Si no viene unit_price, lo copiamos del producto
            if(is_null($line->unit_price)){
                $line->unit_price = $line->product()->value('price');
            }

            //Si no viene tax_rate, lo copiamos del producto (si aplica)
            if(is_null($line->tax_rate)){
                $line->tax_rate = $line->product()->value('tax_rate') ?? 0;
            }
        });
        static::saving(function(QuoteLine $line){
            $line->recalc();
        });
    }

    public function recalc(): void {
        $qty = (int) $this->qty;
        $unit = (float) $this->unit_price;
        $discountRate = (float) $this->discount_rate;
        $taxRate = (float) $this->tax_rate;

        $subtotal = $qty * $unit;
        $discountAmount = $subtotal * ($discountRate / 100);
        $taxBase = $subtotal - $discountAmount;
        $taxAmount = $taxBase * ($taxRate / 100);
        $total = $taxBase + $taxAmount;
        
        $this->subtotal = number_format($subtotal, 2, '.', '');
        $this->discount_amount = number_format($discountAmount, 2, '.', '');
        $this->tax_amount = number_format($taxAmount, 2, '.', '');
        $this->total = number_format($total, 2, '.', '');

}

}
