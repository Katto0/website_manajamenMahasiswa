<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Exception;

class AuthController extends Controller
{
    private string $userFilePath = 'users.json';

    // Menampilkan halaman login
    public function showLogin()
    {
        // Jika sudah login, langsung alihkan ke halaman mahasiswa
        if (session()->has('user_logged_in')) {
            return redirect()->route('mahasiswa.index');
        }
        return view('auth.login');
    }

    // Memproses login
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        try {
            // Membaca data user dari file JSON (File I/O)
            if (!Storage::disk('local')->exists($this->userFilePath)) {
                throw new Exception("Database pengguna tidak ditemukan!");
            }

            $jsonContent = Storage::disk('local')->get($this->userFilePath);
            $users = json_decode($jsonContent, true) ?? [];

            $usernameInput = $request->username;
            $passwordInput = $request->password;
            
            $userFound = null;

            // Mencari user menggunakan Linear Search sederhana
            foreach ($users as $user) {
                if ($user['username'] === $usernameInput) {
                    $userFound = $user;
                    break;
                }
            }

            // Jika user ditemukan dan password cocok
            if ($userFound && password_verify($passwordInput, $userFound['password'])) {
                // Set Session login
                session(['user_logged_in' => true, 'username' => $usernameInput]);
                return redirect()->route('mahasiswa.index')->with('success', 'Selamat datang kembali, ' . $usernameInput . '!');
            }

            throw new Exception("Username atau password salah.");

        } catch (Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    // Memproses logout
    public function logout()
    {
        session()->forget(['user_logged_in', 'username']);
        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar.');
    }
}
