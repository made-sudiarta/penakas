<?php

namespace Database\Seeders;

use App\Models\AkunKeuanganBanjar;
use Illuminate\Database\Seeder;

class AkunKeuanganBanjarSeeder extends Seeder
{
    public function run(): void
    {
        $data = [

            // ======================
            // ASET
            // ======================
            [
                'kode' => '1101',
                'nama' => 'Dana Cash',
                'tipe' => 'aset',
            ],
            [
                'kode' => '1102',
                'nama' => 'Tabungan LPD',
                'tipe' => 'aset',
            ],
            [
                'kode' => '1103',
                'nama' => 'Deposito LPD',
                'tipe' => 'aset',
            ],
            [
                'kode' => '1104',
                'nama' => 'Kas Prajuru',
                'tipe' => 'aset',
            ],

            // ======================
            // PENDAPATAN
            // ======================
            [
                'kode' => '4101',
                'nama' => 'Pendapatan Iuran Warga',
                'tipe' => 'pendapatan',
            ],
            [
                'kode' => '4102',
                'nama' => 'Pendapatan Dana Punia',
                'tipe' => 'pendapatan',
            ],
            [
                'kode' => '4103',
                'nama' => 'Pendapatan Sumbangan',
                'tipe' => 'pendapatan',
            ],
            [
                'kode' => '4104',
                'nama' => 'Pendapatan Iuran Pecingkreman',
                'tipe' => 'pendapatan',
            ],
            [
                'kode' => '4105',
                'nama' => 'Pendapatan Bunga Tabungan',
                'tipe' => 'pendapatan',
            ],
            [
                'kode' => '4106',
                'nama' => 'Pendapatan Bunga Deposito',
                'tipe' => 'pendapatan',
            ],
            [
                'kode' => '4107',
                'nama' => 'Pendapatan Dana SPP TK',
                'tipe' => 'pendapatan',
            ],
            [
                'kode' => '4108',
                'nama' => 'Pendapatan Uang Gedung TK',
                'tipe' => 'pendapatan',
            ],
            [
                'kode' => '4109',
                'nama' => 'Pendapatan TK Lainnya',
                'tipe' => 'pendapatan',
            ],
            [
                'kode' => '4110',
                'nama' => 'Dana Bantuan BKK',
                'tipe' => 'pendapatan',
            ],

            // ======================
            // BEBAN
            // ======================
            [
                'kode' => '5101',
                'nama' => 'Biaya Konsumsi',
                'tipe' => 'beban',
            ],
            [
                'kode' => '5102',
                'nama' => 'Biaya ATK',
                'tipe' => 'beban',
            ],
            [
                'kode' => '5103',
                'nama' => 'Biaya Kebersihan',
                'tipe' => 'beban',
            ],
            [
                'kode' => '5104',
                'nama' => 'Biaya Upakara',
                'tipe' => 'beban',
            ],
            [
                'kode' => '5105',
                'nama' => 'Biaya Transportasi',
                'tipe' => 'beban',
            ],
            [
                'kode' => '5106',
                'nama' => 'Biaya Petias',
                'tipe' => 'beban',
            ],
            [
                'kode' => '5107',
                'nama' => 'Biaya Santunan Duka',
                'tipe' => 'beban',
            ],
            [
                'kode' => '5108',
                'nama' => 'Biaya Partisipasi Kegiatan Banjar',
                'tipe' => 'beban',
            ],
            [
                'kode' => '5109',
                'nama' => 'Biaya Kegiatan Pecingkreman',
                'tipe' => 'beban',
            ],
            [
                'kode' => '5110',
                'nama' => 'Biaya Operasional Banjar',
                'tipe' => 'beban',
            ],
            [
                'kode' => '5111',
                'nama' => 'Biaya Peralatan Banjar',
                'tipe' => 'beban',
            ],
        ];

        foreach ($data as $akun) {
            AkunKeuanganBanjar::updateOrCreate(
                ['kode' => $akun['kode']],
                $akun + [
                    'is_active' => true,
                ]
            );
        }
    }
}