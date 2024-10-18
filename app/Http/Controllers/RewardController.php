<?php

namespace App\Http\Controllers;

use App\Models\Reward;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class RewardController extends Controller
{
    public function index()
    {
        $data = Reward::latest()
            ->paginate(20)
            ->withQueryString();

        return view('panel.pages.reward.index', [
            'data' => $data
        ]);
    }

    public function create()
    {
        return view('panel.pages.reward.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'nullable|string',
            'point' => 'required|numeric',
        ], [
            '*.required' => ':attribute cannot be empty.',
            '*.max' => ':attribute cannot be more than :max characters.',
            '*.numeric' => ':attribute must be a number.',
            'picture.image' => ':attribute must be an image.',
            'picture.mimes' => ':attribute must be a file of type: jpeg, png, jpg.',
            'picture.max' => ':attribute cannot be more than 2MB.',
        ]);

        $input = $request->all();

        if ($request->hasFile('picture')) {
            $filename = time() . '.' . $request->file('picture')->extension();
            $request->file('picture')->storeAs('public/reward', $filename);
            $input['picture'] = $filename;
        }

        $input['slug'] = rand(99, 999) . '-' . Str::slug($input['name']);

        Reward::create($input);

        return redirect()->route('reward.index')->with('success', 'Reward created successfully.');
    }

    public function edit(Reward $reward)
    {
        return view('panel.pages.reward.edit', [
            'data' => $reward
        ]);
    }

    public function update(Request $request, Reward $reward)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'nullable|string',
            'point' => 'required|numeric',
        ], [
            '*.required' => ':attribute cannot be empty.',
            '*.max' => ':attribute cannot be more than :max characters.',
            '*.numeric' => ':attribute must be a number.',
            'picture.image' => ':attribute must be an image.',
            'picture.mimes' => ':attribute must be a file of type: jpeg, png, jpg.',
            'picture.max' => ':attribute cannot be more than 2MB.',
        ]);

        $input = $request->all();

        if ($request->hasFile('picture')) {
            $filename = time() . '.' . $request->file('picture')->extension();
            $request->file('picture')->storeAs('public/reward', $filename);
            $input['picture'] = $filename;

            if ($reward->picture && file_exists(storage_path('app/public/reward/' . $reward->picture))) {
                unlink(storage_path('app/public/reward/' . $reward->picture));
            }
        }

        if ($input['name'] != $reward->name) {
            $input['slug'] = rand(99, 999) . '-' . Str::slug($input['name']);
        }

        $reward->update($input);

        return redirect()->route('reward.index')->with('success', 'Reward updated successfully.');
    }

    public function destroy(Reward $reward)
    {
        if ($reward->picture && file_exists(storage_path('app/public/reward/' . $reward->picture))) {
            unlink(storage_path('app/public/reward/' . $reward->picture));
        }

        $reward->delete();

        return response()->json([
            'success' => true,
            'message' => 'Reward deleted successfully.'
        ]);
    }
}
