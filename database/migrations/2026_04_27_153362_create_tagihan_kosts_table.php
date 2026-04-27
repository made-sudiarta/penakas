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
        Schema::create('tagihan_kosts', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->id();

            $table->foreignId('penghuni_id')
                ->constrained('penghunis')
                ->cascadeOnDelete();

            $table->foreignId('kamar_kost_id')
                ->nullable()
                ->constrained('kamar_kosts')
                ->nullOnDelete();

            $table->unsignedTinyInteger('bulan');
            $table->unsignedSmallInteger('tahun');

            $table->date('tanggal_jatuh_tempo')->nullable();

            $table->decimal('total_tagihan', 15, 2)->default(0);
            $table->decimal('total_dibayar', 15, 2)->default(0);

            $table->enum('status', [
                'belum_lunas',
                'sebagian',
                'lunas',
                'dibatalkan',
            ])->default('belum_lunas');

            $table->text('catatan')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->unique(
                ['penghuni_id', 'bulan', 'tahun'],
                'unique_tagihan_penghuni_bulan_tahun'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihan_kosts');
    }
};
