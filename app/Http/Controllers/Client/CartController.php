<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use App\Models\UserReward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $data = Order::where('user_id', auth()->user()->id)
            ->where('status', 'cart')
            ->first();

        if (empty($data) || $data->detail->count() == 0) {
            return redirect()->route('client.product.index');
        }

        $vouchers = UserReward::where('user_id', auth()->user()->id)
            ->leftJoin('rewards', 'rewards.id', 'user_rewards.reward_id')
            ->where('rewards.type', 'free-shipping')
            ->where('user_rewards.status', 'not-used')
            ->select(
                'rewards.name',
                'rewards.type',
                'user_rewards.*'
            )
            ->get()
            ->groupBy('reward_id');

        return view('client.pages.cart.index', [
            'data' => $data,
            'vouchers' => $vouchers
        ]);
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        // ORDER
        try {
            DB::beginTransaction();

            $order = Order::where('user_id', auth()->user()->id)
                ->where('status', 'cart')
                ->first();

            if (!empty($order)) {

                if ($order->detail()->where('product_id', $request->product_id)->exists()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Material already added to cart',
                    ]);
                }

                $order->detail()->create([
                    'product_id' => $request->product_id,
                ]);
            } else {
                $invoice = "INV-" . rand(99, 999) . "-" . date('YmdHis');

                $order = Order::create([
                    'user_id' => auth()->user()->id,
                    'invoice' => $invoice,
                    'status' => 'cart',
                    'address' => auth()->user()->address ?? null,
                    'phone' => auth()->user()->phone ?? null,
                    'kecamatan' => auth()->user()->kecamatan ?? null,
                    'kelurahan' => auth()->user()->kelurahan ?? null,
                ]);

                $order->detail()->create([
                    'product_id' => $request->product_id,
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Material added to cart successfully',
            ]);
        } catch (\Exception $ex) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $ex->getMessage(),
            ]);
        }
    }

    public function removeFromCart(Request $request)
    {
        $data = OrderDetail::where('id', $request->id)->first();

        $cart = Order::where('id', $data->order_id)
            ->where('status', 'cart')
            ->first();

        if ($cart->detail->count() == 1) {
            $cart->delete();
        } else {
            $data->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Material removed from cart successfully',
        ]);
    }

    public function checkout(Request $request, $id)
    {
        $request->validate([
            'address' => 'required',
            'phone' => 'required',
            'kecamatan' => 'nullable',
            'kelurahan' => 'nullable',
            'shipping' => 'required',
            'product.*.weight' => 'required|numeric|min:1',
            'product.*.picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [], [
            'product.*.weight' => 'weight',
            'product.*.picture' => 'picture',
        ]);

        try {
            DB::beginTransaction();

            $order = Order::find($id);

            // Biaya Ongkos Kirim
            $price = 9000;

            if ($request->shipping == 'dropoff') {
                $price = 0;
            }

            // Jika pakai voucher free shipping
            if ($request->shipping != 'dropoff' && !empty($request->voucher)) {
                $price = 0;

                // ganti status voucher
                UserReward::where('id', $request->voucher)->update([
                    'status' => 'used',
                ]);
            }

            if ($request->payment == 'transfer') {
                // Jika payment transfer
                $status = 'not paid';
            } else {
                // Jika dropoff -> mengunggu barang dikirim
                if ($request->shipping == 'dropoff') {
                    $status = 'waiting delivery';
                }

                // Jika pickup -> pending processing sampai admin menentukan driver
                if ($request->shipping == 'pickup') {
                    $status = 'processing';
                }
            }

            $total_weight = 0;

            foreach ($request->product as $key => $value) {
                $total_weight += $value['weight'];

                // gambar material
                $value['picture'] = null;
                if ($request->hasFile('product.' . $key . '.picture')) {
                    $file = $request->file('product.' . $key . '.picture');
                    $filename = time() . '-' . $file->getClientOriginalName();
                    $file->storeAs('public/order', $filename);

                    $value['picture'] = $filename;
                }

                OrderDetail::where('id', $key)->update([
                    'weight' => $value['weight'],
                    'picture' => $value['picture'],
                ]);
            }

            $order->update([
                'address' => $request->address,
                'phone' => $request->phone,
                'shipping' => $request->shipping,
                'kecamatan' => $request->kecamatan,
                'kelurahan'=> $request->kelurahan,
                'payment' => $request->payment,
                'status' => $status,
                'total_price' => $price,
                'total_weight' => $total_weight
            ]);

            $user = User::find(auth()->user()->id);
            $user->update([
                'address' => $request->address,
                'phone' => $request->phone,
                'kecamatan' => $request->kecamatan,
                'kelurahan' => $request->kelurahan,
            ]);

            DB::commit();
            return redirect()->route('client.order.index');
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }
}
