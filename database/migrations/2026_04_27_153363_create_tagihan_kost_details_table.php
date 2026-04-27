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
        Schema::create('tagihan_kost_details', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tagihan_kost_id')->constrained('tagihan_kosts')->cascadeOnDelete();
            $table->foreignId('jenis_tagihan_kost_id')->nullable()->constrained('jenis_tagihan_kosts')->nullOnDelete();

            $table->string('nama_tagihan');
            $table->decimal('nominal', 15, 2)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihan_kost_details');
    }
};
