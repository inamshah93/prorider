<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'sender_id',
        'supplier_id',
        'pickup_location_id',
        'receiver_id',
        'tracking_number',
        'cod_amount',
        'total_amount',
        'status',
        'pickup_address',
        'delivery_address',
        'weight_kg',
        'picked_up_at',
        'hub_received_at',
        'hub_dispatched_at',
        'out_for_delivery_at',
        'delivered_at'
    ];

    public function sender()
    {
        return $this->belongsTo(\App\Models\User::class, 'sender_id');
    }
    public function supplier()
    {
        return $this->belongsTo(\App\Models\User::class, 'supplier_id');
    }
    public function pickupLocation()
    {
        return $this->belongsTo(PickupLocation::class, 'pickup_location_id');
    }
    public function receiver()
    {
        return $this->belongsTo(Receiver::class, 'receiver_id');
    }
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function tracking()
    {
        return $this->hasMany(OrderTracking::class);
    }
}
