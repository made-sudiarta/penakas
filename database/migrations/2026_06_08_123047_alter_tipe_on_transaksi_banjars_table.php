<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE transaksi_banjars
            MODIFY COLUMN tipe ENUM(
                'pemasukan',
                'pengeluaran',
                'kas-awal'
            ) NOT NULL
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE transaksi_banjars
            MODIFY COLUMN tipe ENUM(
                'pemasukan',
                'pengeluaran'
            ) NOT NULL
        ");
    }
};