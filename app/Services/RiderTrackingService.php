<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderRiderTracking;
use App\Models\Setting;

class RiderTrackingService
{
    /**
     * When a rider scans or receives a parcel.
     */
    public static function handleScan(Order $order, $riderId, $status)
    {
        // Step 1: Get global rider commission %
        $riderPercent = (float) Setting::get('rider_commission_percent', 60);

        // Step 2: Get delivery rate for this order
        $deliveryRate = $order->delivery_rate ?? Setting::get('default_delivery_rate', 150);

        // Step 3: Find how many riders already handled this order
        $totalRiders = OrderRiderTracking::where('order_id', $order->id)
            ->distinct('rider_id')
            ->count();

        // Step 4: Calculate equal share for each rider
        $totalRiderShare = ($deliveryRate * $riderPercent) / 100;
        $equalShare = $totalRiders > 0 ? $totalRiderShare / ($totalRiders + 1) : $totalRiderShare;

        // Step 5: Save tracking record
        $tracking = OrderRiderTracking::create([
            'order_id' => $order->id,
            'rider_id' => $riderId,
            'status' => $status,
            'commission' => $equalShare,
            'started_at' => now(),
        ]);

        // Step 6: Update order status
        $order->update(['status' => $status]);

        return $tracking;
    }

    /**
     * Mark current step as completed.
     */
    public static function completeStep(Order $order, $riderId)
    {
        $record = OrderRiderTracking::where('order_id', $order->id)
            ->where('rider_id', $riderId)
            ->latest()
            ->first();

        if ($record) {
            $record->update(['completed_at' => now()]);
        }

        return $record;
    }

    /**
     * Get order rider history.
     */
    public static function history($orderId)
    {
        return OrderRiderTracking::with('rider:id,name,email')
            ->where('order_id', $orderId)
            ->orderBy('created_at')
            ->get();
    }
}
