<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Validation\ValidationException;

class UnitKerjaController extends Controller
{
    public function index()
    {
        try {
            $data = UnitKerja::with('children')->get();
            return ApiResponse::success('Data unit kerja ditemukan', $data);
        } catch (Exception $e) {
            return ApiResponse::error('Gagal mengambil data unit kerja', 500, $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'nama_unit' => 'required|string|max:255',
                'kode_unit' => 'nullable|string|max:50',
                'parent_id' => 'nullable|exists:unit_kerja,id',
            ]);

            $unit = UnitKerja::create($data);

            return ApiResponse::success('Unit kerja berhasil ditambahkan', $unit, 201);
        } catch (ValidationException $e) {
            return ApiResponse::error(
                "Validasi gagal",
                422,
                $e->errors()
            );
        } catch (Exception $e) {
            return ApiResponse::error('Gagal menambahkan unit kerja', 500, $e->getMessage());
        }
    }

    public function show(UnitKerja $unitKerja)
    {
        try {
            return ApiResponse::success('Detail unit kerja', $unitKerja->load('children', 'parent'));
        } catch (Exception $e) {
            return ApiResponse::error('Gagal mengambil detail unit kerja', 500, $e->getMessage());
        }
    }

    public function update(Request $request, UnitKerja $unitKerja)
    {
        try {
            $data = $request->validate([
                'nama_unit' => 'required|string|max:255',
                'kode_unit' => 'nullable|string|max:50',
                'parent_id' => 'nullable|exists:unit_kerja,id',
            ]);

            $unitKerja->update($data);

            return ApiResponse::success('Unit kerja berhasil diperbarui', $unitKerja->load('children', 'parent'));
        } catch (ValidationException $e) {
            return ApiResponse::error(
                "Validasi gagal",
                422,
                $e->errors()
            );
        } catch (Exception $e) {
            return ApiResponse::error('Gagal memperbarui unit kerja', 500, $e->getMessage());
        }
    }

    public function destroy(UnitKerja $unitKerja)
    {
        try {
            $unitKerja->delete();
            return ApiResponse::success('Unit kerja berhasil dihapus');
        } catch (Exception $e) {
            return ApiResponse::error('Gagal menghapus unit kerja', 500, $e->getMessage());
        }
    }
}
