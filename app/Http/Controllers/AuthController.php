<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function login()
    {
        return view('panel.pages.auth.login');
    }

    public function doLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
            // 'captcha' => 'required|captcha',
        ], [
            '*.required' => ':attribute cannot be empty.',
            // 'captcha.captcha' => 'captcha is not correct. please try again.',
        ]);

        if (Auth::attempt($request->only(['email', 'password']))) {
            $request->session()->regenerate();

            if (auth()->user()->level == 'customer') {
                return redirect()->route('client.home.index');
            }

            return redirect()->route('dashboard');
        }

        return redirect()->back()->with('error', 'Email or Password is not correct');
    }

    public function register()
    {
        return view('panel.pages.auth.register');
    }

    public function doRegister(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
            // 'captcha' => 'required|captcha',
        ], [
            '*.required' => ':attribute cannot be empty.',
            'email.unique' => 'Email already exists. Please use another :attribute.',
            'confirm_password.same' => 'Password does not match.',
            // 'captcha.captcha' => 'captcha is not correct. please try again.',
        ]);

        $request['password'] = Hash::make($request->password);

        $user = User::create($request->all());

        if ($user) {
            Auth::loginUsingId($user->id);

            $request->session()->regenerate();

            return redirect()->route('client.home.index');
        }

        return redirect()->back()->with('error', 'Something went wrong. Please try again.');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('login.index');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }


    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();
        $user = User::where('email', $googleUser->email)->first();
        if (!$user) {
            $user = User::create(['name' => $googleUser->name, 'email' => $googleUser->email, 'password' => \Hash::make(12345678)]);
        }

        Auth::login($user);

        return redirect()->route('client.home.index');
    }

    public function forgotPassword()
    {
        return view('panel.pages.auth.forgot-password');
    }

    public function doForgotPassword()
    {
        $input = request()->all();

        $user = User::where('email', $input['email'])->first();

        if (empty($user)) {
            return redirect()->back()->with('error', 'Email not found');
        }

        $token = bin2hex(random_bytes(32));

        DB::table('password_reset_tokens')->updateOrInsert(
            [
                'email' => $user->email,
            ],
            [
                'token' => $token
            ]
        );

        Mail::send('panel.pages.auth.email.reset-password', ['user' => $user, 'token' => $token], function ($m) use ($user) {
            $m->to($user->email, $user->name)->subject('Reset Password');
        });

        return redirect()->back()->with('success', 'We have sent you an email. Please check your email.');
    }

    public function resetPassword($token)
    {
        return view('panel.pages.auth.reset-password', ['token' => $token]);
    }

    public function doResetPassword(Request $request, $token)
    {
        $this->validate($request, [
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ], [
            '*.required' => ':attribute cannot be empty.',
            'confirm_password.same' => 'Password does not match.',
        ]);

        $data = DB::table('password_reset_tokens')->where('token', $token)->first();
        $user = User::where('email', $data->email)->first();

        if (empty($user)) {
            return redirect()->back()->with('error', 'Email not found');
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        DB::table('password_reset_tokens')->where('email', $user->email)->delete(); 

        return redirect()->route('login.index')->with('success', 'Password reset successfully');
    }
}
