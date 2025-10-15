<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'city',
        'region',
    ];

    public function receivers()
    {
        return $this->hasMany(Receiver::class);
    }

    public function pickupLocations()
    {
        return $this->hasMany(PickupLocation::class);
    }
}
