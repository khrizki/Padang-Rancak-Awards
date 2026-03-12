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
        // Tabel Kecamatan
        Schema::create('kecamatans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kode')->unique();
            $table->string('kota')->default('Padang');
            $table->timestamps();
        });

        // Tabel Kelurahan
        Schema::create('kelurahans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kecamatan_id')->constrained()->cascadeOnDelete();
            $table->string('nama');
            $table->string('kode')->unique();
            $table->timestamps();
        });

        // Tabel RW
        Schema::create('rws', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelurahan_id')->constrained()->cascadeOnDelete();
            $table->string('nama');
            $table->string('nomor_rw');
            $table->timestamps();
        });

        // Tabel RT
        Schema::create('rts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rw_id')->constrained()->cascadeOnDelete();
            $table->string('nama');
            $table->string('nomor_rt');
            $table->enum('status_terdaftar', ['belum', 'sudah'])->default('belum');
            $table->text('alamat')->nullable();
            $table->integer('jumlah_warga')->default(0);
            $table->string('no_hp_ketua_rt')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rts');
        Schema::dropIfExists('rws');
        Schema::dropIfExists('kelurahans');
        Schema::dropIfExists('kecamatans');
    }
};
