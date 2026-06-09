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
        Schema::table('transaksi_banjars', function (Blueprint $table) {

            $table->foreignId('akun_keuangan_banjar_id')
                ->nullable()
                ->after('kategori_dana_banjar_id')
                ->constrained('akun_keuangan_banjars')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksi_banjars', function (Blueprint $table) {
            //
        });
    }
};
