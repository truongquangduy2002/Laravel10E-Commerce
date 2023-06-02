<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegisterMail;
use Pest\Support\Str;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $securityCode = rand(1000, 9999);  // Tạo mã xác thực bảo mật gồm 4 số ngẫu nhiên
        $user = User::all();
        return view('auth.register', compact('securityCode', 'user'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            // 'security_code' => ['required', 'string', 'max:255'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            // 'security_code' => $request->security_code,
        ]);

        // Gửi email thông báo
        Mail::to($user->email)->send(new RegisterMail($user));

        event(new Registered($user));

        Auth::login($user);

        // return redirect('/dashboard');
        return redirect('/dashboard')->with('success', 'Đăng ký tài khoản thành công! Vui lòng kiểm tra email để xác minh.');
    }
}
