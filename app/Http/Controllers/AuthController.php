<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    // Hardcoded user
    private $user = [
        'username' => 'admin',
        'password' => 'password',
        'nama' => 'Admin'
    ];

    public function showLogin()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (
            $credentials['username'] === $this->user['username'] &&
            $credentials['password'] === $this->user['password']
        ) {
            // Set session (tanda sudah login)
            $request->session()->put('login', true);
            $request->session()->put('nama', $this->user['nama']);
            $request->session()->regenerate();
            return redirect()->route('admin.news.index')->with('success', 'Login berhasil!');
        }

        return back()->withErrors(['username' => 'Username atau password salah.']);
    }

    public function showRegister()
    {
        return view('admin.auth.register');
    }

    public function logout(Request $request)
    {
        $request->session()->forget(['login', 'nama']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Berhasil logout');
    }
}