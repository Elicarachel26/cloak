<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {
        if (request()->method() == 'PUT') {
            $this->validate(request(), [
                'name' => 'required|string|max:100',
                'email' => 'required|string|email|max:100|unique:users,email,' . auth()->user()->id,
                'phone' => 'nullable|numeric|digits_between:10,13',
                'address' => 'nullable|string',
                'kecamatan' => 'nullable|string',
            ], [], [
                'name' => 'Full Name',
                'email' => 'Email',
                'phone' => 'Phone',
                'address' => 'Address',
                'kecamatan'=> 'Kecamatan',
            ]);

            $input = request()->all();

            User::where('id', auth()->user()->id)->update([
                'name' => $input['name'],
                'email' => $input['email'],
                'phone' => $input['phone'],
                'address' => $input['address'],
                'kecamatan'=> $input['kecamatan'],
            ]);

            return redirect()->back()->with('success', 'Account updated successfully.');
        }

        return view('client.pages.account.index');
    }

    public function changePassword(Request $request)
    {
        if (request()->method() == 'PUT') {
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
                return redirect()->back()->with('error', 'The current password is incorrect.');
            }

            User::where('id', auth()->user()->id)->update([
                'password' => \Hash::make($request->newpassword),
            ]);

            return redirect()->route('client.account.index')->with('success', 'Password updated successfully.');
        }

        return view('client.pages.account.change-password');
    }
}
