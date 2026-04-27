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
        Schema::create('pembayaran_kosts', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->id();

            $table->foreignId('tagihan_kost_id')
                ->constrained('tagihan_kosts')
                ->cascadeOnDelete();

            $table->date('tanggal_bayar');
            $table->decimal('jumlah_bayar', 15, 2)->default(0);

            $table->enum('metode_pembayaran', [
                'cash',
                'transfer',
                'qris',
                'lainnya',
            ])->default('cash');

            $table->string('bukti_pembayaran')->nullable();
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
        Schema::dropIfExists('pembayaran_kosts');
    }
};
