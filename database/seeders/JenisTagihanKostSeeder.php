<?php

namespace Database\Seeders;

use App\Models\JenisTagihanKost;
use Illuminate\Database\Seeder;

class JenisTagihanKostSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['nama' => 'Harga Kamar', 'nominal_default' => 0],
            ['nama' => 'Air', 'nominal_default' => 50000],
            ['nama' => 'Listrik', 'nominal_default' => 100000],
            ['nama' => 'Internet', 'nominal_default' => 50000],
            ['nama' => 'Duktang', 'nominal_default' => 20000],
            ['nama' => 'Kebersihan', 'nominal_default' => 25000],
        ];

        foreach ($items as $item) {
            JenisTagihanKost::query()->updateOrCreate(
                ['nama' => $item['nama']],
                [
                    'nominal_default' => $item['nominal_default'],
                    'is_bulanan' => true,
                    'is_active' => true,
                ]
            );
        }
    }
}