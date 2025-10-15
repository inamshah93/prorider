<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class RiderProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cnic',
        'vehicle_type',
        'vehicle_number',
        'license_number',
        'address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
