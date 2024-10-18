<?php

namespace App\Http\Controllers\Client;

use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserOrderController extends Controller
{
    public function index()
    {
        $data = Order::where('user_id', auth()->user()->id)
            ->latest()
            ->paginate(20);

        return view('client.pages.order.index', [
            'data' => $data
        ]);
    }

    public function proofPayment($id)
    {
        $data = Order::findOrFail($id);

        if (request()->hasFile('proof_of_payment')) {
            $filename = Str::random(8) . '.' . request()->proof_of_payment->getClientOriginalExtension();
            request()->proof_of_payment->move(public_path('proof_of_payment'), $filename);

            $data->update([
                'proof_payment' => $filename,
                'status' => 'processing'
            ]);
        }

        return redirect()->back()->with('success', 'Proof of payment uploaded successfully.');
    }
}
