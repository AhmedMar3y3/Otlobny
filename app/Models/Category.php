<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasImage;

class Category extends Model
{
    use HasFactory, HasImage;

    protected $fillable = ['name', 'image'];


    public function stores()
    {
        return $this->hasMany(Store::class);
    }

    public function hasStores()
    {
        return $this->stores()->exists();
    }
}
