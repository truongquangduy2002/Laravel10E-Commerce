<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Pest\Support\Str;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        $securityCode = rand(1000, 9999); // Tạo mã xác thực bảo mật gồm 4 số ngẫu nhiên
        // $securityCode = Str::random(4);
        return view('auth.login', compact('securityCode'));
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();


        $notification = array(
            'message' => 'Login Successfully',
            'alert-type' => 'success'
        );

        $url = '';
        $user = $request->user();

        if ($user->role === 'admin') {
            // Nếu người dùng là admin, chuyển hướng đến màn hình admin
            $url = '/admin/dashboard';
        } else if ($user->role === 'vendor') {
            // Nếu người dùng là vendor, chuyển hướng đến màn hình vendor
            $url = '/vendor/dashboard';
        } else if ($user->role === 'user') {
            // Nếu người dùng là user, chuyển hướng đến màn hình user
            $url = '/dashboard';
        }

        return redirect()->intended($url)->with($notification);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/dashboard');
    }
}
