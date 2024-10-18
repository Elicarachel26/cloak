<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Reward;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProduct = Product::count();
        $totalReward = Reward::count();
        $totalCustomer = User::where('level', 'customer')->count();

        return view('panel.pages.dashboard.index', [
            'totalProduct' => $totalProduct,
            'totalReward' => $totalReward,
            'totalCustomer' => $totalCustomer
        ]);
    }
}
