<?php

namespace App\Http\Controllers;

use App\Models\QuoteRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('customer.dashboard');
        }

        return back()->withErrors([
            'email' => 'بيانات الدخول غير صحيحة.',
        ])->onlyInput('email');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users',
            'company_name' => 'required|string|max:191',
            'phone' => 'required|string|max:191',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'company_name' => $request->company_name,
            'phone' => $request->phone,
            'role' => 'customer',
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('customer.dashboard')->with('success', 'تم إنشاء الحساب بنجاح');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    public function dashboard()
    {
        $user = Auth::user();
        $quotes = QuoteRequest::where('user_id', $user->id)->latest()->get();

        return view('customer.dashboard', compact('user', 'quotes'));
    }
}
