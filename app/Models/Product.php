<?php

namespace App\Models;

use App\Traits\HasImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes, HasImage;

    protected $fillable = [
        'name',
        'image',
        'description',
        'price',
        'has_stock',
        'stock',
        'has_discount',
        'discount_price',
        'product_category_id',
        'store_id',
        'discount_percentage',
        'is_active',
        'is_featured',
        'is_frequent',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'has_stock' => 'boolean',
        'has_discount' => 'boolean',
        'is_featured' => 'boolean',
        'is_frequent' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getPriceAfterDiscountAttribute()
    {
        return $this->has_discount ? $this->discount_price : $this->price;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    public function scopeSearchByName($query, $name)
    {
        return $query->where('name', 'like', '%' . $name . '%');
    }

    public function hasOrders()
    {
        return $this->orderItems()->exists();
    }
}
