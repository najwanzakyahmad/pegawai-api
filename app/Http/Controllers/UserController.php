<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index()
    {
        try {
            $users = User::all();
            return ApiResponse::success('Data user ditemukan', $users);
        } catch (Exception $e) {
            return ApiResponse::error('Gagal mengambil data user', 500, $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'username'      => 'required|string|unique:users,username',
                'password'      => 'required|string|min:6',
                'nama_lengkap'  => 'required|string',
                'role'          => 'required|in:admin,user',
            ]);

            $data['password'] = Hash::make($data['password']);

            $user = User::create($data);

            return ApiResponse::success('User berhasil ditambahkan', $user, 201);
        } catch (ValidationException $e) {
            return ApiResponse::error(
                "Validasi gagal",
                422,
                $e->errors()
            );
        } catch (Exception $e) {
            return ApiResponse::error('Gagal menambahkan user', 500, $e->getMessage());
        }
    }

    public function show(User $user)
    {
        try {
            return ApiResponse::success('Detail user', $user);
        } catch (Exception $e) {
            return ApiResponse::error('Gagal mengambil detail user', 500, $e->getMessage());
        }
    }

    public function update(Request $request, User $user)
    {
        try {
            $data = $request->validate([
                'username'      => 'required|string|unique:users,username,' . $user->id,
                'password'      => 'nullable|string|min:6',
                'nama_lengkap'  => 'required|string',
                'role'          => 'required|in:admin,user',
            ]);

            if (!empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }

            $user->update($data);

            return ApiResponse::success('User berhasil diperbarui', $user);
        } catch (ValidationException $e) {
            return ApiResponse::error(
                "Validasi gagal",
                422,
                $e->errors()
            );
        } catch (Exception $e) {
            return ApiResponse::error('Gagal memperbarui user', 500, $e->getMessage());
        }
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();
            return ApiResponse::success('User berhasil dihapus');
        } catch (Exception $e) {
            return ApiResponse::error('Gagal menghapus user', 500, $e->getMessage());
        }
    }
}
