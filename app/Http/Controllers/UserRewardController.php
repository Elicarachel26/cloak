<?php

namespace App\Http\Controllers;

use App\Models\UserReward;
use Illuminate\Http\Request;

class UserRewardController extends Controller
{
    public function index()
    {
        $data = UserReward::with(['user', 'reward'])
            ->latest()
            ->paginate(20);

        return view('panel.pages.user-reward.index', [
            'data' => $data,
        ]);
    }

    public function delivered($id)
    {
        $data = UserReward::find($id);

        $data->update([
            'status' => 'delivered',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Reward status successfully change to delivered.',
        ]);
    }
}
