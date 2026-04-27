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
        Schema::create('transaksi_banjars', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->id();

            $table->foreignId('kategori_dana_banjar_id')
                ->constrained('kategori_dana_banjars')
                ->cascadeOnDelete();

            $table->date('tanggal');
            $table->enum('tipe', ['pemasukan', 'pengeluaran']);
            $table->string('judul');
            $table->decimal('nominal', 15, 2)->default(0);
            $table->text('keterangan')->nullable();
            $table->string('foto_nota')->nullable();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_banjars');
    }
};
