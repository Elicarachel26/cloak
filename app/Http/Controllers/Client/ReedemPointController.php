<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Reward;
use App\Models\User;
use App\Models\UserReward;
use Illuminate\Http\Request;

class ReedemPointController extends Controller
{
    public function index()
    {
        $data = UserReward::where('user_id', auth()->user()->id)
            ->latest()
            ->paginate(20);

        $rewards = Reward::where('status', 1)
            ->orderBy('name', 'asc')
            ->get();

        return view('client.pages.reedem-point.index', [
            'data' => $data,
            'rewards' => $rewards
        ]);
    }

    public function store(Request $request)
    {
        $reward = Reward::find($request->id);

        // cek apakah user punya point yang cukup
        if (auth()->user()->point < $reward->point) {
            return response()->json([
                'success' => false,
                'message' => 'Your point is not enough.',
            ]);
        }

        $user = User::find(auth()->user()->id);
        $user->update([
            'point' => $user->point - $reward->point
        ]);

        if ($reward->type == 'item') {
            $status = 'processing';
        } else {
            $status = 'not-used';
        }

        $reedem_id = 'RD-' . rand(99, 999) . '-' . date('YmdHis');

        UserReward::create([
            'user_id' => auth()->user()->id,
            'reward_id' => $request->id,
            'reedem_id' => $reedem_id,
            'status' => $status
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Reward has been reedemed.',
        ]);
    }

    public function complete(Request $request)
    {
        $data = UserReward::find($request->id);

        $data->update([
            'status' => 'completed'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Reward has been completed.',
        ]);
    }
}
