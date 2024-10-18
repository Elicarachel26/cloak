<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::where('status', 1)
            ->latest()
            ->take(6)
            ->get();

        return view('client.pages.home.index', [
            'products' => $products
        ]);
    }
}
