<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\RiderTrackingService;
use Illuminate\Http\Request;

class RiderScanController extends Controller
{
    public function receiveByScan(Request $request)
    {
        $request->validate([
            'tracking_number' => 'required|string|exists:orders,tracking_number',
        ]);

        $rider = $request->user(); // current logged-in rider
        $order = Order::where('tracking_number', $request->tracking_number)->firstOrFail();

        // Define flow of status transitions
        $nextStep = [
            'created' => 'picked_up',
            'picked_up' => 'hub_received',
            'hub_received' => 'out_for_delivery',
            'out_for_delivery' => 'delivered',
            'delivered' => null,
        ];

        $currentStatus = $order->status;
        $nextStatus = $nextStep[$currentStatus] ?? null;

        if (!$nextStatus) {
            return response()->json([
                'status' => false,
                'message' => 'Order cannot move further.',
            ], 400);
        }

        // Record rider tracking & commission
        $tracking = RiderTrackingService::handleScan($order, $rider->id, $nextStatus);

        return response()->json([
            'status' => true,
            'message' => "Order status updated to '{$nextStatus}'",
            'data' => [
                'order' => $order->fresh(),
                'tracking' => $tracking,
            ],
        ]);
    }
}
