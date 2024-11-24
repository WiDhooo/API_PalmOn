<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class RegisterController extends Controller
{
    //
    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'name' => 'required|max:45',
            'password' => [
                'required',
                'string',
                'min:8', // minimal 8 karakter
                'regex:/[a-z]/', // harus ada huruf kecil
                'regex:/[A-Z]/', // harus ada huruf besar
                'regex:/[0-9]/', // harus ada angka
                'regex:/[@$!%*?&]/', // harus ada simbol
            ],
        ]);

        try {
            $user = User::create([
                'email' => $request->input('email'),
                'name' => $request->input('name'),
                'password' => Hash::make($request->input('password'))
            ]);

            return response()->json(['message' => 'Registrasi berhasil.'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Registrasi gagal.'], 500);
        }
    }
}
