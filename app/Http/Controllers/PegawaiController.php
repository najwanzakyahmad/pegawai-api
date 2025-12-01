<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Exception;
use Illuminate\Validation\ValidationException;

class PegawaiController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Pegawai::with(['golongan', 'eselon', 'jabatan', 'agama', 'unitKerja']);

            if ($search = $request->get('search')) {
                $query->where(function ($q) use ($search) {
                    $q->where('nip', 'like', "%{$search}%")
                      ->orWhere('nama', 'like', "%{$search}%");
                });
            }

            if ($unitId = $request->get('unit_kerja_id')) {
                $query->where('unit_kerja_id', $unitId);
            }

            $perPage = $request->get('per_page', 10);

            $data = $query->paginate($perPage);

            return ApiResponse::success("Data pegawai ditemukan", [
                "data" => $data->items(),
                "pagination" => [
                    "current_page" => $data->currentPage(),
                    "per_page"     => $data->perPage(),
                    "total"        => $data->total(),
                    "last_page"    => $data->lastPage()
                ]
            ]);
        } catch (Exception $e) {
            return ApiResponse::error("Gagal mengambil data pegawai", 500, $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $data = $this->validateData($request);

            if ($request->hasFile('foto')) {
                $data['foto_path'] = $request->file('foto')
                    ->store('foto-pegawai', 'public');
            }

            $pegawai = Pegawai::create($data);

            return ApiResponse::success("Pegawai berhasil ditambahkan", $pegawai, 201);
        } catch (ValidationException $e) {
            return ApiResponse::error(
                "Validasi gagal",
                422,
                $e->errors()
            );
        } catch (Exception $e) {
            return ApiResponse::error("Gagal memperbarui pegawai", 500, $e->getMessage());
        }
    }

    public function show(Pegawai $pegawai)
    {
        try {
            return ApiResponse::success("Detail pegawai",
                $pegawai->load(['golongan', 'eselon', 'jabatan', 'agama', 'unitKerja'])
            );
        } catch (Exception $e) {
            return ApiResponse::error("Gagal mengambil detail pegawai", 500, $e->getMessage());
        }
    }

    public function update(Request $request, Pegawai $pegawai)
    {
        try {
            $data = $this->validateData($request, $pegawai->id);

            if ($request->hasFile('foto')) {
                if ($pegawai->foto_path) {
                    Storage::disk('public')->delete($pegawai->foto_path);
                }

                $data['foto_path'] = $request->file('foto')
                    ->store('foto-pegawai', 'public');
            }

            $pegawai->update($data);

            return ApiResponse::success("Pegawai berhasil diperbarui", $pegawai);
        } catch (ValidationException $e) {
            return ApiResponse::error(
                "Validasi gagal",
                422,
                $e->errors()
            );
        } catch (Exception $e) {
            return ApiResponse::error("Gagal memperbarui pegawai", 500, $e->getMessage());
        }
    }

    public function destroy(Pegawai $pegawai)
    {
        try {
            $pegawai->delete();

            return ApiResponse::success("Pegawai berhasil dihapus");
        } catch (Exception $e) {
            return ApiResponse::error("Gagal menghapus pegawai", 500, $e->getMessage());
        }
    }

    protected function validateData(Request $request, $id = null)
    {
        $nipRule = 'required|digits:10|unique:pegawai,nip';
        if ($id) {
            $nipRule .= ',' . $id;
        }

        return $request->validate([
            'nip'           => $nipRule,
            'nama'          => 'required|string',
            'tempat_lahir'  => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat'        => 'required|string',

            'golongan_id'   => 'required|exists:golongan,id',
            'eselon_id'     => 'required|exists:eselon,id',
            'jabatan_id'    => 'required|exists:jabatan,id',
            'tempat_tugas'  => 'required|string',
            'agama_id'      => 'required|exists:agama,id',
            'unit_kerja_id' => 'required|exists:unit_kerja,id',

            'no_hp'         => 'required|string',
            'npwp'          => 'nullable|string',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
    }
}
