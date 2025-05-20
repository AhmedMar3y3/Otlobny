<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Super extends Authenticatable
{
    use HasFactory;

    protected $table = 'supers';

    protected $fillable = [
        'name',
        'email',
        'password',
        'code',
    ];

     protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

     protected static function boot()
    {
        parent::boot();

        static::creating(function ($admin) {
            if (empty($admin->code)) {
                $admin->code = self::generateUniqueCode();
            }
        });
    }

    protected static function generateUniqueCode()
    {
        do {
            $code = strtoupper(substr(md5(uniqid()), 0, 6));
        } while (self::where('code', $code)->exists());

        return $code;
    }
}
