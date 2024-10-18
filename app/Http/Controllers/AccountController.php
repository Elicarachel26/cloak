<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AccountController extends Controller
{

    // public function create()
    // {
    //     $kecamatans = User::all(); // Mengambil semua kecamatan dari database
    //     return view('panel.pages.account.index', compact('kecamatans'));
    // }
    public function account()
    {
        // Pass the current user's location data to the view
        return view('panel.pages.account.index', [
            'user' => auth()->user(),
        ]);
    }

    public function changePhoto(Request $request)
    {
        try {
            $this->validate($request, [
                'photo' => 'required|mimes:jpeg,png,jpg|max:2048',
            ], [
                'photo.required' => ':attribute cannot be empty.',
                'photo.mimes' => ':attribute must be jpeg/png/jpg.',
                'photo.max' => ':attribute cannot be more than 2MB.',
            ], [
                'photo' => 'Photo',
            ]);

            if ($request->hasFile('photo')) {
                $filename = time() . '.' . $request->file('photo')->extension();
                $request->file('photo')->storeAs('public/account', $filename);

                if (auth()->user()->photo && file_exists(url('storage/account/' . auth()->user()->photo))) {
                    unlink(url('storage/account/' . auth()->user()->photo));
                }

                User::where('id', auth()->user()->id)->update([
                    'photo' => $filename,
                ]);
            }

            return response()->json([
                'status' => true,
                'message' => 'Photo successfully updated.',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function accountUpdate(Request $request)
    {
        try {
            $this->validate($request, [
                'name' => 'required|string|max:100',
                'email' => 'required|string|email|max:100|unique:users,email,' . auth()->user()->id,
                'kecamatan' => 'nullable|string',
                'kelurahan' => 'nullable|string',
            ], [], [
                'name' => 'Full Name',
                'email' => 'Email',
                'kecamatan' => 'Kecamatan',
                'kelurahan' => 'Kelurahan',
            ]);

            User::where('id', auth()->user()->id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'kecamatan' => $request->kecamatan,
                'kelurahan' => $request->kelurahan,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Account successfully updated.',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }

        
        $user->kecamatan = $request->input('kecamatan');
        $user->kelurahan = $request->input('kelurahan');
        $user->save();
    }

    public function changePassword(Request $request)
    {
        try {
            $this->validate($request, [
                'password' => 'required|string',
                'newpassword' => 'required|string|min:8',
                'confirmpassword' => 'required|same:newpassword',
            ], [
                '*.required' => ':attribute cannot be empty.',
                '*.min' => ':attribute min. :min characters.',
                'confirmpassword.same' => ':attribute not same with new password.',
            ], [
                'password' => 'Current Password',
                'newpassword' => 'New Password',
                'confirmpassword' => 'Password Confirmation',
            ]);

            if (!\Hash::check($request->password, auth()->user()->password)) {
                return response()->json([
                    'status' => false,
                    'message' => 'The current password is incorrect.',
                ]);
            }

            User::where('id', auth()->user()->id)->update([
                'password' => \Hash::make($request->newpassword),
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Password successfully updated.',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
}
