<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        // Ambil data User untuk dropdown
        $users = User::select('name', 'nip')->orderBy('name')->get();
        return view('auth.login', compact('users'));
    }

    public function login(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'nip' => 'required',
            'password' => 'required',
        ]);

        // 2. CARI USER MANUAL (Bypass Auth::attempt)
        $user = User::where('nip', $request->nip)->first();

        // Jika user tidak ditemukan
        if (!$user) {
            return back()->withErrors(['password' => 'NIP tidak ditemukan di database.']);
        }

        // 3. CEK PASSWORD MANUAL
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Password salah.']);
        }

        // 4. JIKA LOLOS: Login Manual & Cek Role
        // Paksa login
        Auth::login($user); 
        $request->session()->regenerate();

        // Cek Role (Sesuai request: Inspeksi & Admin boleh masuk)
        if ($user->role !== 'inspeksi' && $user->role !== 'admin') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->with('error_role', 'Maaf, Role Anda (' . $user->role . ') tidak memiliki akses.');
        }

        // 5. REDIRECT SUKSES
        return redirect()->route('serasi.index');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}