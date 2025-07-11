<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('departemens')) {
            Schema::create('departemens', function (Blueprint $table) {
                $table->id();
                $table->string('nama_departemen');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('departemens');
    }
};
