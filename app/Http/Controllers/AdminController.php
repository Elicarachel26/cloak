<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $data = User::where('level', '<>', 'customer')
            ->orderBy('name', 'asc')
            ->paginate(20)
            ->withQueryString();

        return view('panel.pages.admin.index', [
            'data' => $data
        ]);
    }

    public function create()
    {
        return view('panel.pages.admin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            '*.required' => ':attribute cannot be empty.',
            '*.unique' => ':attribute already exists. Please use another :attribute.',
            '*.max' => ':attribute cannot be more than :max characters.',
            'photo.image' => ':attribute must be image',
            'email.email' => ':attribute must be an email address',
            'photo.max' => ':attribute cannot be more than 2 MB',
            'photo.mimes' => ':attribute must be jpeg/png/jpg',
        ], [
            'name' => 'Full Name',
            'email' => 'Email Address',
            'password' => 'Password',
            'photo' => 'Photo',
        ]);

        $input = $request->all();

        $input['photo'] = null;
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension();
            $filename = Str::slug($request->name . '-' . time()) . '.' . $extension;
            $request->file('photo')->storeAs('public/account', $filename);
            $input['photo'] = $filename;
        }

        $input['password'] = Hash::make($input['password']);

        User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => $input['password'],
            'photo' => $input['photo'],
            'level' => $input['level'],
        ]);

        return redirect()->route('admin.index')->with('success', Str::ucfirst($input['level']) . ' has been created.');
    }

    public function edit($id)
    {
        $data = User::find($id);

        return view('panel.pages.admin.edit', [
            'data' => $data
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            '*.required' => ':attribute cannot be empty.',
            '*.unique' => ':attribute already exists. Please use another :attribute.',
            '*.max' => ':attribute tidak boleh lebih dari :max karakter',
            'photo.image' => ':attribute must be image',
            'email.email' => ':attribute must be an email address',
            'photo.max' => ':attribute cannot be more than 2 MB',
            'photo.mimes' => ':attribute must be jpeg/png/jpg',
        ], [
            'name' => 'Full Name',
            'email' => 'Email Address',
            'photo' => 'Photo',
        ]);

        $input = $request->all();

        $data = User::find($id);


        $input['photo'] = $data->photo;
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension();
            $filename = Str::slug($request->name . '-' . time()) . '.' . $extension;
            $request->file('photo')->storeAs('public/account', $filename);
            $input['photo'] = $filename;

            if (!empty($data->photo) && file_exists(public_path('storage/account/' . $data->photo))) {
                unlink(public_path('storage/account/' . $data->photo));
            }
        }

        $input['password'] = $data->password;
        if ($request->password) {
            $input['password'] = Hash::make($input['password']);
        }

        $data->update([
            'name' => $input['name'],
            'email' => $input['email'],
            'photo' => $input['photo'],
            'password' => $input['password'],
            'level' => $input['level'],
        ]);

        return redirect()->route('admin.index')->with('success', Str::ucfirst($input['level']) . ' has been updated.');
    }

    public function destroy($id)
    {
        $data = User::find($id);

        if (!empty($data->photo) && file_exists(public_path('storage/account/' . $data->photo))) {
            unlink(public_path('storage/account/' . $data->photo));
        }

        $data->delete();

        return response()->json([
            'success' => true,
            'message' => 'Account has been deleted.',
        ]);
    }
}
