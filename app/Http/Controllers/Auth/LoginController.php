<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
// use App\Http\Requests\LoginRequest;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Kiểm tra security_code
            $user = $request->user();
            if ($user->security_code !== $request->security_code) {
                Auth::logout();
                return redirect()->back()->withErrors(['security_code' => 'Invalid security code.']);
            }

            return redirect()->intended('/dashboard');
        }

        return redirect()->back()->withErrors(['email' => 'These credentials do not match our records.']);
    }
}
