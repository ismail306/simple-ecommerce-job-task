<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model
{
    protected $fillable = ['product_id', 'name', 'image', 'price'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
