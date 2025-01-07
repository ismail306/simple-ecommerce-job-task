<?php

namespace App\Models\Web;

use App\Models\Admin\Product;
use App\Models\Admin\ProductVariant;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'carts';

    protected $fillable = [
        'session_id',
        'product_id',
        'product_variant_id',
        'quantity'
    ];

    public $timestamps = true;

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }
}
