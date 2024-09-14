<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'prospect_id',
        'user_id',
        'product_id',
        'quantity',
        'ppl_cost',
        'ppl_sell',
        'vat',
        'nett_total',
        'total',
        'ppl_profit',
        'total_profit',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function prospect(): BelongsTo
    {
        return $this->belongsTo(Prospect::class, 'prospect_id');
    }

    /**
     * Helper method to get the product name directly.
     */
    public function getProductNameAttribute()
    {
        return $this->product ? $this->product->name : null;
    }
}
