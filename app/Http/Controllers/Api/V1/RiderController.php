<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Services\RiderTrackingService;

class RiderController extends Controller
{
    /**
     * Assign a rider to an order manually (admin or hub action)
     */
    public function assignRider(Request $request, $orderId)
    {
        $request->validate([
            'rider_id' => 'required|exists:users,id',
            'status' => 'required|string',
        ]);

        $order = Order::findOrFail($orderId);

        $tracking = RiderTrackingService::assignRider($order, $request->rider_id, $request->status);

        return response()->json([
            'status' => true,
            'message' => 'Rider assigned successfully',
            'data' => $tracking,
        ]);
    }
}
