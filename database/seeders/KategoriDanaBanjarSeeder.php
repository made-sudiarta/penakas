<?php

namespace Database\Seeders;

use App\Models\KategoriDanaBanjar;
use Illuminate\Database\Seeder;

class KategoriDanaBanjarSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'nama' => 'Dana Banjar',
                'deskripsi' => 'Dana utama Banjar untuk pemasukan dan pengeluaran umum.',
            ],
            [
                'nama' => 'Dana Prajuru',
                'deskripsi' => 'Dana khusus Prajuru Banjar.',
            ],
        ];

        foreach ($items as $item) {
            KategoriDanaBanjar::query()->updateOrCreate(
                ['nama' => $item['nama']],
                [
                    'deskripsi' => $item['deskripsi'],
                    'is_active' => true,
                ]
            );
        }
    }
}