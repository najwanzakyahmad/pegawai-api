<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Eselon;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Validation\ValidationException;

class EselonController extends Controller
{
    public function index()
    {
        try {
            $data = Eselon::all();
            return ApiResponse::success('Data eselon ditemukan', $data);
        } catch (Exception $e) {
            return ApiResponse::error('Gagal mengambil data eselon', 500, $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'kode_eselon' => 'required|string|max:50',
                'keterangan'  => 'nullable|string',
            ]);

            $es = Eselon::create($data);

            return ApiResponse::success('Eselon berhasil ditambahkan', $es, 201);
        } catch (ValidationException $e) {
            return ApiResponse::error(
                "Validasi gagal",
                422,
                $e->errors()
            );
        } catch (Exception $e) {
            return ApiResponse::error('Gagal menambahkan eselon', 500, $e->getMessage());
        }
    }

    public function show(Eselon $eselon)
    {
        try {
            return ApiResponse::success('Detail eselon', $eselon);
        } catch (Exception $e) {
            return ApiResponse::error('Gagal mengambil detail eselon', 500, $e->getMessage());
        }
    }

    public function update(Request $request, Eselon $eselon)
    {
        try {
            $data = $request->validate([
                'kode_eselon' => 'required|string|max:50',
                'keterangan'  => 'nullable|string',
            ]);

            $eselon->update($data);

            return ApiResponse::success('Eselon berhasil diperbarui', $eselon);
        } catch (ValidationException $e) {
            return ApiResponse::error(
                "Validasi gagal",
                422,
                $e->errors()
            );
        } catch (Exception $e) {
            return ApiResponse::error('Gagal memperbarui eselon', 500, $e->getMessage());
        }
    }

    public function destroy(Eselon $eselon)
    {
        try {
            $eselon->delete();
            return ApiResponse::success('Eselon berhasil dihapus');
        } catch (Exception $e) {
            return ApiResponse::error('Gagal menghapus eselon', 500, $e->getMessage());
        }
    }
}
