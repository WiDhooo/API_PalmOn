<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserUmum;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserUmumController extends Controller
{
    public function index()
    {
        try {
            $users = UserUmum::all();
            return response()->json($users);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal mengambil data: ' . $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'username' => 'required|string|max:50|unique:user_umums,username',
                'password' => [
                    'required',
                    'string',
                    Password::min(8)
                        ->letters()
                        ->mixedCase()
                        ->numbers()
                        ->symbols(),
                ],
                'email' => 'required|email|unique:user_umums,email',
                'no_telp' => 'required|string',
                'profile_picture' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
                'tanggal_lahir' => 'nullable|date',
                'jenis_kelamin' => 'nullable|string|in:Laki-laki,Perempuan',
            ]);

            $fileName = null;
            if ($request->hasFile('profile_picture')) {
                $fileName = 'profile-' . uniqid() . '.' . $request->profile_picture->extension();
                $request->profile_picture->move(public_path('assets/img'), $fileName);
            }

            $user = new UserUmum();
            $user->username = $validated['username'];
            $user->password = $validated['password']; // No extra hashing needed
            $user->email = $validated['email'];
            $user->no_telp = $validated['no_telp'];
            $user->profile_picture = $fileName ? 'assets/img/' . $fileName : null;
            $user->tanggal_lahir = $request->input('tanggal_lahir');
            $user->jenis_kelamin = $request->input('jenis_kelamin');
            $user->save();

            return response()->json('Registrasi telah berhasil', 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Registrasi gagal: ' . $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $user = UserUmum::findOrFail($id);
            return response()->json($user);
        } catch (\Exception $e) {
            return response()->json(['error' => 'User tidak ditemukan: ' . $e->getMessage()], 404);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $user = UserUmum::findOrFail($id);
    
            $validated = $request->validate([
                'username' => 'sometimes|required|string|max:50|unique:user_umums,username,' . $user->id,
                'password' => [
                    'sometimes',
                    'string',
                    Password::min(8)
                        ->letters()
                        ->mixedCase()
                        ->numbers()
                        ->symbols(),
                ],
                'email' => 'sometimes|required|email|unique:user_umums,email,' . $user->id,
                'no_telp' => 'sometimes|required|string',
                'profile_picture' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
                'tanggal_lahir' => 'nullable|date',
                'jenis_kelamin' => 'nullable|string|in:Laki-laki,Perempuan',
            ]);
    
            if ($request->hasFile('profile_picture')) {
                if ($user->profile_picture && file_exists(public_path($user->profile_picture))) {
                    unlink(public_path($user->profile_picture));
                }
    
                $fileName = 'profile-' . uniqid() . '.' . $request->profile_picture->extension();
                $request->profile_picture->move(public_path('assets/img'), $fileName);
                $user->profile_picture = 'assets/img/' . $fileName;
            }
    
            $user->username = $validated['username'] ?? $user->username;
            $user->password = isset($validated['password']) ? $validated['password'] : $user->password; // Use without extra hashing
            $user->email = $validated['email'] ?? $user->email;
            $user->no_telp = $validated['no_telp'] ?? $user->no_telp;
            $user->tanggal_lahir = $request->input('tanggal_lahir', $user->tanggal_lahir);
            $user->jenis_kelamin = $request->input('jenis_kelamin', $user->jenis_kelamin);
            $user->save();
    
            return response()->json($user);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Update gagal: ' . $e->getMessage()], 500);
        }
    }
    
    public function destroy($id)
    {
        try {
            $user = UserUmum::findOrFail($id);

            if ($user->profile_picture && file_exists(public_path($user->profile_picture))) {
                unlink(public_path($user->profile_picture));
            }

            $user->delete();
            return response()->json(['message' => 'User berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menghapus user: ' . $e->getMessage()], 500);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required_without:email|string|max:50',
            'email' => 'required_without:username|email',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        $user = $request->has('username')
            ? UserUmum::where('username', $request->username)->first()
            : UserUmum::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials',
            ], 401);
        }

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'user_id' => $user->id,
        ], 200);
    }
}
