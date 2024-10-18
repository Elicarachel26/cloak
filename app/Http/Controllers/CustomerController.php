<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $data = User::where('level', 'customer')
            ->orderBy('name', 'asc')
            ->paginate(20)
            ->withQueryString();

        return view('panel.pages.customer.index', [
            'data' => $data
        ]);
    }

    public function edit($id)
    {
        $data = User::find($id);
        return view('panel.pages.customer.edit', [
            'data' => $data
        ]);
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'phone' => 'nullable|numeric|digits_between:10,13',
        'address' => 'nullable|string',
        'point' => 'nullable|numeric',
        'kecamatan' => 'nullable',
        'kelurahan' => 'nullable',
    ], [
        '*.required' => ':attribute cannot be empty.',
        '*.unique' => ':attribute already exists. Please use another :attribute.',
        '*.max' => ':attribute tidak boleh lebih dari :max karakter',
        '*.numeric' => ':attribute must be a number',
        '*.digits_between' => ':attribute must be between :min and :max digits',
        'photo.image' => ':attribute must be image',
        'email.email' => ':attribute must be an email address',
        'photo.max' => ':attribute cannot be more than 2 MB',
        'photo.mimes' => ':attribute must be jpeg/png/jpg',
    ], [
        'name' => 'Full Name',
        'email' => 'Email Address',
        'photo' => 'Photo',
        'phone' => 'Phone Number',
        'address' => 'Address',
        'point' => 'Point',
        'kecamatan'=> 'Kecamatan',
        'kelurahan'=> 'Kelurahan',
    ]);

    $input = $request->all();

    if ($request->hasFile('photo')) {
        $file = $request->file('photo');
        $extension = $file->getClientOriginalExtension();
        $filename = Str::slug($request->name . '-' . time()) . '.' . $extension;
        $request->file('photo')->storeAs('public/account', $filename);
        $input['photo'] = $filename;
    } else {
        $input['photo'] = null; // Set to null if no photo is uploaded
    }

    // Create a new User instance and save it to the database
    User::create([
        'name' => $input['name'],
        'email' => $input['email'],
        'photo' => $input['photo'],
        'phone' => $input['phone'],
        'address' => $input['address'],
        'point' => $input['point'],
        'kecamatan' => $input['kecamatan'],
        'kelurahan' => $input['kelurahan'],
        'level' => 'customer', // Assuming you want to set level as customer
    ]);

    return redirect()->route('customer.index')->with('success', 'Customer has been created.');
}

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'phone' => 'nullable|numeric|digits_between:10,13',
            'address' => 'nullable|string',
            'point' => 'nullable|numeric',
            'kecamatan' => 'required',
            'kelurahan' => 'required',
        ], [
            '*.required' => ':attribute cannot be empty.',
            '*.unique' => ':attribute already exists. Please use another :attribute.',
            '*.max' => ':attribute tidak boleh lebih dari :max karakter',
            '*.numeric' => ':attribute must be a number',
            '*.digits_between' => ':attribute must be between :min and :max digits',
            'photo.image' => ':attribute must be image',
            'email.email' => ':attribute must be an email address',
            'photo.max' => ':attribute cannot be more than 2 MB',
            'photo.mimes' => ':attribute must be jpeg/png/jpg',
        ], [
            'name' => 'Full Name',
            'email' => 'Email Address',
            'photo' => 'Photo',
            'phone' => 'Phone Number',
            'address' => 'Address',
            'point' => 'Point',
            'kecamatan'=> 'Kecamatan',
            'kelurahan'=> 'Kelurahan',
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

        $data->update([
            'name' => $input['name'],
            'email' => $input['email'],
            'photo' => $input['photo'],
            'phone' => $input['phone'],
            'address' => $input['address'],
            'point' => $input['point'],
            'kecamatan' => $input['kecamatan'],
            'keluaran' => $input['kelurahan'],
        ]);

        return redirect()->route('customer.index')->with('success', 'Customer has been updated.');
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
            'message' => 'Customer has been deleted.',
        ]);
    }
}
