<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister() {
        return view('auth.register');
    }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string|min:3|max:40',
            'email' => 'required|email|ends_with:@gmail.com|unique:users,email',
            'password' => 'required|string|min:6|max:12',
            'phone' => ['required', 'regex:/^08[0-9]{8,11}$/'],
        ], [

            'name.min' => 'Nama lengkap minimal harus 3 huruf.',
            'name.max' => 'Nama lengkap maksimal harus 40 huruf.',
            'email.ends_with' => 'Email harus mempunyai domain @gmail.com.',
            'password.min' => 'Password minimal harus 6 huruf.',
            'password.max' => 'Password maksimal harus 12 huruf.',
            'phone.regex' => 'Nomor handphone harus diawali dengan angka 08.',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => 'user',
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login menggunakan akun baru kamu.');
    }

    public function showLogin() {
        return view('auth.login');
    }
    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('user.catalog');
        }

        return back()->withErrors(['loginError' => 'Email atau password salah!']);
    }
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
