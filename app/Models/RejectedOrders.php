<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RejectedOrders extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'delegate_id',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function delegate()
    {
        return $this->belongsTo(Delegate::class);
    }
    public function scopeWithRelations($query)
    {
        return $query->with(['order', 'delegate']);
    }
}
