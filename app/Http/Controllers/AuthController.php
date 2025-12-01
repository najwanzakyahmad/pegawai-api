<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Exception;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'username' => 'required',
                'password' => 'required',
            ]);

            $user = User::where('username', $credentials['username'])->first();

            if (! $user || ! Hash::check($credentials['password'], $user->password)) {
                return ApiResponse::error('Username atau password salah', 401);
            }

            $token = $user->createToken('api-token')->plainTextToken;

            return ApiResponse::success('Login berhasil', [
                'token' => $token,
                'user'  => $user,
            ]);
        } catch (Exception $e) {
            return ApiResponse::error('Terjadi kesalahan saat login', 500, $e->getMessage());
        }
    }

    public function me(Request $request)
    {
        try {
            return ApiResponse::success('User aktif', $request->user());
        } catch (Exception $e) {
            return ApiResponse::error('Gagal mengambil data user aktif', 500, $e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return ApiResponse::success('Logout berhasil');
        } catch (Exception $e) {
            return ApiResponse::error('Gagal logout', 500, $e->getMessage());
        }
    }
}
