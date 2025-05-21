<?php

namespace App\Models;

use App\Traits\HasImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialOrderImage extends Model
{
    use HasFactory, HasImage;

    protected $fillable = [
        'special_order_id',
        'image',
    ];


    public function specialOrder()
    {
        return $this->belongsTo(SpecialOrder::class);
    }
}
