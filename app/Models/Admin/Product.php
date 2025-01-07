<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'category_id','status'];

    public function options()
    {
        return $this->hasMany(ProductOption::class);
    }
}
