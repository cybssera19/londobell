<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // 1. Menampilkan Halaman Register
    public function showRegister() {
        return view('auth.register');
    }

    // 2. Memproses Pendaftaran User Biasa
    public function register(Request $request) {
        // Validasi ketat sesuai instruksi Pak Noa
        $request->validate([
            'name' => 'required|string|min:3|max:40',
            'email' => 'required|email|ends_with:@gmail.com|unique:users,email',
            'password' => 'required|string|min:6|max:12',
            'phone' => ['required', 'regex:/^08[0-9]{8,11}$/'], // Validasi HP wajib diawali 08
        ], [
            // Custom pesan error bahasa Indonesia agar user paham salahnya di mana
            'name.min' => 'Nama lengkap minimal harus 3 huruf.',
            'name.max' => 'Nama lengkap maksimal harus 40 huruf.',
            'email.ends_with' => 'Email harus mempunyai domain @gmail.com.',
            'password.min' => 'Password minimal harus 6 huruf.',
            'password.max' => 'Password maksimal harus 12 huruf.',
            'phone.regex' => 'Nomor handphone harus diawali dengan angka 08.',
        ]);

        // Jika lolos validasi, simpan data ke database
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Password wajib disandikan (bcrypt)
            'phone' => $request->phone,
            'role' => 'user', // Otomatis diset sebagai user biasa
        ]);

        // Redirect ke halaman login dengan pesan sukses
        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login menggunakan akun baru kamu.');
    }

    // 3. Menampilkan Halaman Login
    public function showLogin() {
        return view('auth.login');
    }

    // 4. Memproses Masuk Akun (Login)
    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Coba cocokkan email dan password di database
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Jika yang login adalah Admin default tadi, arahkan ke dashboard admin
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            // Jika user biasa, arahkan ke katalog barang
            return redirect()->route('user.catalog');
        }

        // Jika salah, balikkan ke halaman login dengan error
        return back()->withErrors(['loginError' => 'Email atau password salah!']);
    }

    // 5. Memproses Keluar Akun (Logout)
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
