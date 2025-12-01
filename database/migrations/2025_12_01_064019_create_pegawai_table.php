<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id();
            $table->string('nip')->unique();
            $table->string('nama');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->text('alamat');

            $table->foreignId('golongan_id')->constrained('golongan');
            $table->foreignId('eselon_id')->constrained('eselon');
            $table->foreignId('jabatan_id')->constrained('jabatan');
            $table->string('tempat_tugas');

            $table->foreignId('agama_id')->constrained('agama');
            $table->foreignId('unit_kerja_id')->constrained('unit_kerja');

            $table->string('no_hp')->nullable();
            $table->string('npwp')->nullable();
            $table->string('foto_path')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};
