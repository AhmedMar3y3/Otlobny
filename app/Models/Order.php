<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Support\Str;
use App\Enums\OrderPayTypes;
use App\Enums\OrderPayStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'delegate_id',
        'order_num',
        'lat',
        'lng',
        'map_desc',
        'title',
        'price',
        'delivery_price',
        'status',
        'total_price',
        'pay_type',
        'pay_status',
    ];

    protected $casts = [
        'status'    => OrderStatus::class,
        'pay_type'  => OrderPayTypes::class,
        'pay_status' => OrderPayStatus::class
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function delegate()
    {
        return $this->belongsTo(Delegate::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    private static function generateOrderNum()
    {
        do {
            $orderNum = Str::random(8);
        } while (self::where('order_num', $orderNum)->exists());

        return $orderNum;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->order_num = self::generateOrderNum();
        });
    }
}
