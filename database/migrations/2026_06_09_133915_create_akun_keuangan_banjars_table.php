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
        Schema::create('akun_keuangan_banjars', function (Blueprint $table) {

            $table->id();

            $table->string('kode')->unique();

            $table->string('nama');

            $table->enum('tipe', [
                'aset',
                'pendapatan',
                'beban',
                'modal',
            ]);

            $table->boolean('is_active')
                ->default(true);

            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('akun_keuangan_banjars');
    }
};
