<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Cari pengguna berdasarkan email
        $user = User::where('email', $request->input('email'))->first();

        if ($user && Hash::check($request->input('password'), $user->password)) {
            // Jika password valid, kembalikan data pengguna
            return response()->json([
                'email' => $user->email,
                'name' => $user->name
            ], 200);
        } else {
            // Jika login gagal, kembalikan pesan error
            return response()->json(['error' => 'Email atau password salah.'], 401);
        }
    }

    public function logout(Request $request)
    {
        // Proses logout (jika ada logika tambahan, tambahkan di sini)
        return response()->json(['message' => 'Logout successful.'], 200);
    }
}
