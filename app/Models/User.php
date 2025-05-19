<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\HasImage;
use Illuminate\Support\Str;
use App\Traits\HttpResponses;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use App\Services\Auth\SendVerificationCodeService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HttpResponses, HasImage;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'image',
        'birth_date',
        'password',
        'is_active',
        'completed_info',
        'is_blocked',
        'is_notify',
        'owned_referral_code',
        'used_referral_code',
        'lat',
        'lng',
        'map_desc',
        'title',
        'code',
        'is_verified',
        'fcm_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
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
        'completed_info' => 'boolean',
        'is_notify' => 'boolean',
        'is_verified' => 'boolean',
        'is_active' => 'boolean',
        'is_blocked' => 'boolean',
        'birth_date' => 'date',
        'password' => 'hashed',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }


    public static function generateReferralCode()
    {
        return Str::random(8);
    }

    public function updateLocation($data): void
    {
        $this->update($data + ['completed_info' => true]);

        $this->addresses()->updateOrCreate(
            ['title' => 'default'],
            [
                'lat'      => $data['lat'],
                'lng'      => $data['lng'],
                'map_desc' => $data['map_desc'],
                'title'    => 'default',
            ]
        );
    }


    public function markAsVerified()
    {
        $this->update([
            'is_active' => true,
            'code' => null,
        ]);
    }

    public function updatePassword($password)
    {
        $this->update([
            'password' => $password,
            'code' => null,
            'is_verified' => false,
        ]);
    }

    public function sendVerificationCode()
    {
        $this->update([
            'code' => '123456',
        ]);

        // (new SendVerificationCodeService())->sendCodeToUser($this);
    }

    public function login()
    {
        return $this->createToken('user-token')->plainTextToken;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->owned_referral_code = self::generateReferralCode();
        });
    }

    public function hasNoOrdersOrCompletedOrders()
    {
        return !$this->orders()->exists() || $this->orders()->where('status', 2)->exists();
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


    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
}
