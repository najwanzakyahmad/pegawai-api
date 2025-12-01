<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Validation\ValidationException;

class JabatanController extends Controller
{
    public function index()
    {
        try {
            $data = Jabatan::all();
            return ApiResponse::success('Data jabatan ditemukan', $data);
        } catch (Exception $e) {
            return ApiResponse::error('Gagal mengambil data jabatan', 500, $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'nama_jabatan' => 'required|string|max:255',
            ]);

            $jab = Jabatan::create($data);

            return ApiResponse::success('Jabatan berhasil ditambahkan', $jab, 201);
        } catch (ValidationException $e) {
            return ApiResponse::error(
                "Validasi gagal",
                422,
                $e->errors()
            );
        } catch (Exception $e) {
            return ApiResponse::error('Gagal menambahkan jabatan', 500, $e->getMessage());
        }
    }

    public function show(Jabatan $jabatan)
    {
        try {
            return ApiResponse::success('Detail jabatan', $jabatan);
        } catch (Exception $e) {
            return ApiResponse::error('Gagal mengambil detail jabatan', 500, $e->getMessage());
        }
    }

    public function update(Request $request, Jabatan $jabatan)
    {
        try {
            $data = $request->validate([
                'nama_jabatan' => 'required|string|max:255',
            ]);

            $jabatan->update($data);

            return ApiResponse::success('Jabatan berhasil diperbarui', $jabatan);
        } catch (ValidationException $e) {
            return ApiResponse::error(
                "Validasi gagal",
                422,
                $e->errors()
            );
        } catch (Exception $e) {
            return ApiResponse::error('Gagal memperbarui jabatan', 500, $e->getMessage());
        }
    }

    public function destroy(Jabatan $jabatan)
    {
        try {
            $jabatan->delete();
            return ApiResponse::success('Jabatan berhasil dihapus');
        } catch (Exception $e) {
            return ApiResponse::error('Gagal menghapus jabatan', 500, $e->getMessage());
        }
    }
}
