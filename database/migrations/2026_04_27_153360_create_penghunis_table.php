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
        Schema::create('penghunis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kamar_kost_id')->nullable()->constrained('kamar_kosts')->nullOnDelete();

            $table->string('nama');
            $table->string('no_hp')->nullable();
            $table->text('alamat')->nullable();

            $table->date('tanggal_masuk')->nullable();
            $table->date('tanggal_keluar')->nullable();

            $table->enum('status', ['aktif', 'keluar'])->default('aktif');
            $table->text('catatan')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penghunis');
    }
};
