<?php

namespace App\Services;

use App\Models\Order;
use App\Models\SenderRate;
use App\Models\Setting;

class OrderPricingService
{
    /**
     * Calculate pricing for a given order dynamically.
     */
    public static function calculate(Order $order)
    {
        // Step 1: Fetch sender's rate or default
        $rate = SenderRate::where('sender_id', $order->sender_id)->first();
        $deliveryRate = $rate->delivery_rate ?? Setting::get('default_delivery_rate', 150);
        $returnRate   = $rate->return_rate ?? Setting::get('default_return_rate', 100);

        // Step 2: Fetch global rider commission percentage
        $riderPercent = (float) Setting::get('rider_commission_percent', 60);

        // Step 3: Compute commission & platform share
        $riderCommission = ($deliveryRate * $riderPercent) / 100;
        $platformFee = $deliveryRate - $riderCommission;

        // Step 4: Save to order record
        $order->update([
            'delivery_rate'    => $deliveryRate,
            'return_rate'      => $returnRate,
            'rider_commission' => $riderCommission,
            'platform_fee'     => $platformFee,
        ]);

        return $order;
    }
}
