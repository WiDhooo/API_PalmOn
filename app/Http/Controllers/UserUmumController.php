<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserUmum;

class UserUmumController extends Controller
{
    public function index()
    {
        return response()->json(UserUmum::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:50',
            'email' => 'required|email|unique:user_umums,email',
            'no_telp' => 'required|string|max:15',
            'alamat' => 'required|string|max:500',
        ]);

        $userUmum = UserUmum::create($validated);
        return response()->json($userUmum, 201);
    }

    public function show(UserUmum $userUmum)
    {
        return response()->json($userUmum);
    }

    public function update(Request $request, UserUmum $userUmum)
    {
        $validated = $request->validate([
            'nama' => 'string|max:50',
            'email' => 'email|unique:user_umums,email,' . $userUmum->id,
            'no_telp' => 'string|max:15',
            'alamat' => 'string|max:500',
        ]);

        $userUmum->update($validated);
        return response()->json($userUmum);
    }

    public function destroy(UserUmum $userUmum)
    {
        $userUmum->delete();
        return response()->json(null, 204);
    }
}
