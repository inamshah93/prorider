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
        'pickup_address',
        'contact_person',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
