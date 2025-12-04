<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Daftar Pegawai</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 11px;
        }
        h2 {
            text-align: center;
            margin-bottom: 6px;
        }
        .subtitle {
            text-align: center;
            font-size: 10px;
            color: #555;
            margin-bottom: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #333;
            padding: 4px 3px;
            text-align: left;
        }
        th {
            background-color: #eee;
            font-size: 10px;
        }
        td {
            font-size: 10px;
        }
        .text-center {
            text-align: center;
        }
        .nowrap {
            white-space: nowrap;
        }
    </style>
</head>
<body>

<h2>DAFTAR PEGAWAI</h2>
<div class="subtitle">
    Dicetak pada: {{ now()->format('d-m-Y H:i') }}
</div>

<table>
    <thead>
        <tr>
            <th class="text-center">No</th>
            <th>NIP</th>
            <th>Nama</th>
            <th>Tempat Lahir</th>
            <th>Alamat</th>
            <th class="nowrap">Tanggal Lahir</th>
            <th class="text-center">L/P</th>
            <th>Gol.</th>
            <th>Eselon</th>
            <th>Jabatan</th>
            <th>Tempat Tugas</th>
            <th>Agama</th>
            <th>Unit Kerja</th>
            <th>No. HP</th>
            <th>NPWP</th>
        </tr>
    </thead>
    <tbody>
        @forelse($pegawai as $p)
            <tr>
                {{-- # (index) --}}
                <td class="text-center">{{ $loop->iteration }}</td>

                {{-- NIP --}}
                <td class="nowrap">{{ $p->nip }}</td>

                {{-- Nama --}}
                <td>{{ $p->nama }}</td>

                {{-- Tempat Lahir --}}
                <td>{{ $p->tempat_lahir }}</td>

                {{-- Alamat --}}
                <td>{{ $p->alamat }}</td>

                {{-- Tanggal Lahir --}}
                <td class="nowrap">
                    @if($p->tanggal_lahir)
                        {{ \Carbon\Carbon::parse($p->tanggal_lahir)->format('d-m-Y') }}
                    @else
                        -
                    @endif
                </td>

                {{-- L/P --}}
                <td class="text-center">
                    {{ $p->jenis_kelamin }}
                    {{-- kalau mau full:
                    {{ $p->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                    --}}
                </td>

                {{-- Gol. --}}
                <td>{{ $p->golongan->kode_gol ?? '-' }}</td>

                {{-- Eselon --}}
                <td>{{ $p->eselon->kode_eselon ?? '-' }}</td>

                {{-- Jabatan --}}
                <td>{{ $p->jabatan->nama_jabatan ?? '-' }}</td>

                {{-- Tempat Tugas --}}
                <td>{{ $p->tempat_tugas }}</td>

                {{-- Agama --}}
                <td>{{ $p->agama->nama_agama ?? '-' }}</td>

                {{-- Unit Kerja --}}
                <td>{{ $p->unitKerja->nama_unit ?? '-' }}</td>

                {{-- No. HP --}}
                <td class="nowrap">{{ $p->no_hp }}</td>

                {{-- NPWP --}}
                <td class="nowrap">{{ $p->npwp ?? '-' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="15" class="text-center">
                    Tidak ada data pegawai.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

</body>
</html>
