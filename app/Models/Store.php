<?php

namespace App\Models;

use App\Traits\HasImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Store extends Authenticatable
{
    use HasFactory, HasImage;

    protected $fillable = [
        'name',
        'image',
        'email',
        'password',
        'rating',
        'number_of_ratings',
        'delivery_time_min',
        'delivery_time_max',
        'category_id',
        'is_active',
        'lat',
        'lng',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'password' => 'hashed',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function productCategories()
    {
        return $this->hasMany(ProductCategory::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    public function scopeSearchByName($query, $name)
    {
        return $name ? $query->where('name', 'like', '%' . $name . '%') : $query;
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}