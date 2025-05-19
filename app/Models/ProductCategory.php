<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'store_id',
    ];  

    public function products()
    {
        return $this->hasMany(Product::class, 'product_category_id');
    }
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
    public function hasProducts()
    {
        return $this->products()->exists();
    }
}
