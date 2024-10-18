<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class PickupController extends Controller
{
    public function index()
    {
        $data = Order::where('shipping', 'pickup')
            ->where('driver_id', auth()->user()->id)
            ->where(function ($q) {
                $q->where('status', 'pending')
                    ->orWhere('status', '<>', 'cart')
                    ->orWhere('status', '<>', 'not paid')
                    ->orWhere('status', '<>', 'waiting delivery');
            })
            ->latest()
            ->paginate(20);

        return view('panel.pages.pickup.index', [
            'data' => $data
        ]);
    }

    public function pickedup($id)
    {
        $order = Order::find($id);

        $order->update([
            'status' => 'picked up'
        ]);

        return  response()->json([
            'success' => true,
            'message' => 'Order ' . $order->invoice . ' has been picked up.'
        ]);
    }

    public function delivered($id)
    {
        $order = Order::find($id);

        $order->update([
            'status' => 'delivered'
        ]);

        return  response()->json([
            'success' => true,
            'message' => 'Order ' . $order->invoice . ' has been delivered.'
        ]);
    }
}
