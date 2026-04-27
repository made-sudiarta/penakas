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
        Schema::create('kamar_kosts', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kamar');
            $table->string('nomor_kamar')->nullable();
            $table->decimal('harga_default', 15, 2)->default(0);
            $table->enum('status', ['kosong', 'terisi', 'maintenance'])->default('kosong');
            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kamar_kosts');
    }
};
