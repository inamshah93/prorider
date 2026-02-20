<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreOrderRequest;
use App\Http\Requests\Api\CancelOrderRequest;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\OrderPricingService;


class OrderController extends Controller
{
    // list orders for the authenticated user (sender)
    public function index(Request $r)
    {
        $user = $r->user();
        // sender view
        $orders = Order::where('sender_id', $user->id)
            ->with(['items', 'receiver', 'pickupLocation'])
            ->latest()
            ->paginate(12);

        return response()->json(['status' => true, 'message' => 'Orders fetched', 'data' => $orders]);
    }

    // store order (sender creates)
    public function store(StoreOrderRequest $r)
    {
        $user = $r->user();
        $payload = $r->validated();

        $order = Order::create([
            'sender_id' => $user->id,
            'pickup_location_id' => $payload['pickup_location_id'] ?? null,
            'receiver_id' => $payload['receiver_id'],
            'tracking_number' => strtoupper('PR-' . Str::random(8)),
            'status' => 'created',
            'cod_amount' => $payload['cod_amount'] ?? 0,
            'pickup_address' => $payload['pickup_address'] ?? null,
            'delivery_address' => $payload['delivery_address'] ?? null,
            'weight_kg' => $payload['weight_kg'] ?? null,
        ]);

        $total = 0;
        foreach ($payload['items'] as $it) {
            $item = OrderItem::create([
                'order_id' => $order->id,
                'name' => $it['name'],
                'quantity' => $it['quantity'],
                'price' => $it['price'],
            ]);
            $total += $it['price'] * $it['quantity'];
        }

        $order->total_amount = $total;
        $order->save();

        // Apply pricing dynamically based on sender
        OrderPricingService::calculate($order);

        return response()->json([
            'status' => true,
            'message' => 'Order created successfully',
            'data' => $order,
        ], 201);
    }

    // show single order
    public function show(Request $r, $id)
    {
        $user = $r->user();
        $order = Order::with(['items', 'receiver', 'pickupLocation', 'tracking'])->findOrFail($id);

        if ($order->sender_id !== $user->id) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
        }

        return response()->json(['status' => true, 'message' => 'Order detail', 'data' => $order]);
    }

    // cancel by sender
    public function cancel(CancelOrderRequest $r, $id)
    {
        $user = $r->user();
        $order = Order::findOrFail($id);

        if ($order->sender_id !== $user->id) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
        }

        // only allow cancel if not yet picked up / in delivery
        if (in_array($order->status, ['picked_up', 'out_for_delivery', 'delivered'])) {
            return response()->json(['status' => false, 'message' => 'Cannot cancel. Order already in progress.'], 422);
        }

        $order->status = 'cancelled';
        $order->save();

        // add tracking event (optional)
        $order->tracking()->create([
            'user_id' => $user->id,
            'event' => 'cancelled',
            'notes' => $r->input('reason')
        ]);

        return response()->json(['status' => true, 'message' => 'Order cancelled', 'data' => $order]);
    }
}
