<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('laporans', function (Blueprint $table) {
            // Tambahkan kolom relasi baru
            $table->unsignedBigInteger('kategori_id')->nullable()->after('phone');
            $table->unsignedBigInteger('pelapor_id')->nullable()->after('kategori_id');

            // Hapus kolom lama jika tidak dipakai lagi
            $table->dropColumn('category');
            $table->dropColumn('reporter_name');
            
            $table->foreign('kategori_id')->references('id')->on('kategoris')->onDelete('set null');
            $table->foreign('pelapor_id')->references('id')->on('users')->onDelete('set null');
        });
    }


    public function down(): void
    {
        Schema::table('laporans', function (Blueprint $table) {
            // Kembalikan kolom lama
            $table->string('category')->nullable();
            $table->string('reporter_name')->nullable();

            // Hapus kolom relasi baru
            $table->dropColumn('kategori_id');
            $table->dropColumn('pelapor_id');
        });
    }
};
