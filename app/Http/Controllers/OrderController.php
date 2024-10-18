<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $data = Order::with(['user', 'detail'])
            ->latest()
            ->paginate(20);

        $drivers = User::where('level', 'driver')->get();

        return view('panel.pages.order.index', [
            'data' => $data,
            'drivers' => $drivers
        ]);
    }

    public function setDriver($id)
    {
        $order = Order::find($id);

        $order->update([
            'driver_id' => request('driver_id')
        ]);

        return redirect()->back()->with('success', 'Driver for order ' . $order->invoice . ' has been assigned.');
    }

    public function cancel($id)
    {
        $order = Order::find($id);

        $order->update([
            'status' => 'cancelled'
        ]);

        return  response()->json([
            'success' => true,
            'message' => 'Order ' . $order->invoice . ' has been canceled.'
        ]);
    }

    public function complete($id)
    {
        $order = Order::find($id);

        $order->update([
            'status' => 'completed'
        ]);

        $point = 0;
        if ($order->total_weight >= 3 && $order->total_weight <= 5) {
            $point = 50;
        } elseif ($order->total_weight >= 6 && $order->total_weight <= 10) {
            $point = 100;
        } elseif ($order->total_weight > 10) {
            $point = 150;
        }

        $user = User::find($order->user_id);
        $user->update([
            'point' => $user->point + $point
        ]);

        return  response()->json([
            'success' => true,
            'message' => 'Order ' . $order->invoice . ' has been completed.'
        ]);
    }
}
