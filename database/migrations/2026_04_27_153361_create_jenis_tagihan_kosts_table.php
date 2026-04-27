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
        Schema::create('jenis_tagihan_kosts', function (Blueprint $table) {
            $table->id();

            $table->string('nama');
            $table->decimal('nominal_default', 15, 2)->default(0);
            $table->boolean('is_bulanan')->default(true);
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_tagihan_kosts');
    }
};
