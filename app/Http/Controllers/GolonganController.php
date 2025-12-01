<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Golongan;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Validation\ValidationException;

class GolonganController extends Controller
{
    public function index()
    {
        try {
            $data = Golongan::all();
            return ApiResponse::success('Data golongan ditemukan', $data);
        } catch (Exception $e) {
            return ApiResponse::error('Gagal mengambil data golongan', 500, $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'kode_gol'   => 'required|string|max:50',
                'keterangan' => 'nullable|string',
            ]);

            $gol = Golongan::create($data);

            return ApiResponse::success('Golongan berhasil ditambahkan', $gol, 201);
        } catch (ValidationException $e) {
            return ApiResponse::error(
                "Validasi gagal",
                422,
                $e->errors()
            );
        } catch (Exception $e) {
            return ApiResponse::error('Gagal menambahkan golongan', 500, $e->getMessage());
        }
    }

    public function show(Golongan $golongan)
    {
        try {
            return ApiResponse::success('Detail golongan', $golongan);
        } catch (Exception $e) {
            return ApiResponse::error('Gagal mengambil detail golongan', 500, $e->getMessage());
        }
    }

    public function update(Request $request, Golongan $golongan)
    {
        try {
            $data = $request->validate([
                'kode_gol'   => 'required|string|max:50',
                'keterangan' => 'nullable|string',
            ]);

            $golongan->update($data);

            return ApiResponse::success('Golongan berhasil diperbarui', $golongan);
        } catch (ValidationException $e) {
            return ApiResponse::error(
                "Validasi gagal",
                422,
                $e->errors()
            );
        } catch (Exception $e) {
            return ApiResponse::error('Gagal memperbarui golongan', 500, $e->getMessage());
        }
    }

    public function destroy(Golongan $golongan)
    {
        try {
            $golongan->delete();
            return ApiResponse::success('Golongan berhasil dihapus');
        } catch (Exception $e) {
            return ApiResponse::error('Gagal menghapus golongan', 500, $e->getMessage());
        }
    }
}
