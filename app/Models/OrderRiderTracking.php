<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderRiderTracking extends Model
{
    use HasFactory;

    protected $table = 'order_rider_tracking';

    protected $fillable = [
        'order_id',
        'rider_id',
        'status',
        'commission',
        'started_at',
        'completed_at',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function rider()
    {
        return $this->belongsTo(User::class, 'rider_id');
    }
}
