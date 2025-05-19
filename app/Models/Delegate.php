<?php

namespace App\Models;

use App\Traits\HasImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class Delegate extends Authenticatable
{
    use HasFactory, SoftDeletes, HasImage, HasApiTokens, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'country_code',
        'is_active',
        'email',
        'image',
        'password',
        'code',
        'code_expire',
        'is_verified',
        'admin_code',
        'fcm_token',
        'lat',
        'lng',
        'map_desc',
        'title',
        'completed_info',
        'birth_date',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'code_expire' => 'datetime',
        'is_active' => 'boolean',
        'is_verified' => 'boolean',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function isCodeExpired()
    {
        return $this->code_expire && now()->gt($this->code_expire);
    }


    public function markAsVerified()
    {
        $this->update([
            'is_active' => true,
            'code' => null,
            'code_expire' => null,
        ]);
    }

    public function updatePassword($password)
    {
        $this->update([
            'password' => $password,
            'code' => null,
            'code_expire' => null,
            'is_verified' => false,
        ]);
    }

    public function sendVerificationCode()
    {
        $this->update([
            'code' => '123456',
            'code_expire' => now()->addMinutes(1),
        ]);

        // (new SendVerificationCodeService())->sendCodeToUser($this);
    }

    public function login()
    {
        return $this->createToken('delegate-token')->plainTextToken;
    }

    public function changePassword(string $newPassword): void
    {
        $this->password = $newPassword;
        $this->save();
    }

    public function verifyPassword(string $password): bool
    {
        return Hash::check($password, $this->password);
    }

    public function updateLocation($data): void
    {
        $this->update($data + ['completed_info' => true]);
    
        $this->update(
            ['title' => 'default'],
            [
                'lat'      => $data['lat'],
                'lng'      => $data['lng'],
                'map_desc' => $data['map_desc'],
                'title'    => 'default',
            ]
        );
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function rejectedOrders()
    {
        return $this->hasMany(RejectedOrders::class);
    }

    public function routeNotificationForFcm()
    {
        return $this->fcm_token;
    }
}
