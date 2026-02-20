<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SenderProfile extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'business_name',
        'default_pickup_location_id',
        'contact_person',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function defaultPickupLocation()
    {
        return $this->belongsTo(PickupLocation::class, 'default_pickup_location_id');
    }
}
