<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function riderProfile()
    {
        return $this->hasOne(RiderProfile::class);
    }

    public function senderProfile()
    {
        return $this->hasOne(SenderProfile::class);
    }

    public function sentOrders()
    {
        return $this->hasMany(Order::class, 'sender_id');
    }

    public function deliveredOrders()
    {
        return $this->hasMany(Order::class, 'rider_id');
    }
    public function receivers()
    {
        return $this->hasMany(Receiver::class);
    }

    public function pickupLocations()
    {
        return $this->hasMany(PickupLocation::class);
    }
}
