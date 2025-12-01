<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Agama;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Validation\ValidationException;

class AgamaController extends Controller
{
    public function index()
    {
        try {
            $data = Agama::all();
            return ApiResponse::success('Data agama ditemukan', $data);
        } catch (Exception $e) {
            return ApiResponse::error('Gagal mengambil data agama', 500, $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'nama_agama' => 'required|string|max:100',
            ]);

            $ag = Agama::create($data);

            return ApiResponse::success('Agama berhasil ditambahkan', $ag, 201);
        } catch (ValidationException $e) {
            return ApiResponse::error(
                "Validasi gagal",
                422,
                $e->errors()
            );
        } catch (Exception $e) {
            return ApiResponse::error('Gagal menambahkan agama', 500, $e->getMessage());
        }
    }

    public function show(Agama $agama)
    {
        try {
            return ApiResponse::success('Detail agama', $agama);
        } catch (Exception $e) {
            return ApiResponse::error('Gagal mengambil detail agama', 500, $e->getMessage());
        }
    }

    public function update(Request $request, Agama $agama)
    {
        try {
            $data = $request->validate([
                'nama_agama' => 'required|string|max:100',
            ]);

            $agama->update($data);

            return ApiResponse::success('Agama berhasil diperbarui', $agama);
        } catch (ValidationException $e) {
            return ApiResponse::error(
                "Validasi gagal",
                422,
                $e->errors()
            );
        } catch (Exception $e) {
            return ApiResponse::error('Gagal memperbarui agama', 500, $e->getMessage());
        }
    }

    public function destroy(Agama $agama)
    {
        try {
            $agama->delete();
            return ApiResponse::success('Agama berhasil dihapus');
        } catch (Exception $e) {
            return ApiResponse::error('Gagal menghapus agama', 500, $e->getMessage());
        }
    }
}
