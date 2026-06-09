<?php

namespace App\Filament\Widgets;

use App\Models\KamarKost;
use App\Models\PembayaranKost;
use App\Models\TagihanKost;
use App\Models\TransaksiBanjar;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PenaKasOverview extends StatsOverviewWidget
{
    // protected ?string $heading = 'Dana Banjar Adat Minggir';

    // protected ?string $description = 'Rincian Dana Banjar dan Prajuru';

    // protected static ?int $sort = 1;

    // protected function getColumns(): int|array
    // {
    //     return [
    //         'default' => 1,
    //         'md' => 2,
    //         'xl' => 2,
    //     ];
    // }

    // protected function getStats(): array
    // {
    //     $totalKamar = KamarKost::query()->count();

    //     $kamarKosong = KamarKost::query()
    //         ->where('status', 'kosong')
    //         ->count();

    //     $kamarTerisi = KamarKost::query()
    //         ->where('status', 'terisi')
    //         ->count();

    //     $totalTagihanKost = TagihanKost::query()
    //         ->sum('total_tagihan');

    //     $totalPembayaranKost = PembayaranKost::query()
    //         ->sum('jumlah_bayar');

    //     $totalTunggakanKost = TagihanKost::query()
    //         ->whereIn('status', ['belum_lunas', 'sebagian'])
    //         ->get()
    //         ->sum(fn (TagihanKost $tagihan) => max(0, $tagihan->total_tagihan - $tagihan->total_dibayar));

    //     $pemasukanBanjar = TransaksiBanjar::query()
    //         ->where('tipe', 'pemasukan')
    //         ->sum('nominal');

    //     $pengeluaranBanjar = TransaksiBanjar::query()
    //         ->where('tipe', 'pengeluaran')
    //         ->sum('nominal');

    //     $saldoBanjar = $pemasukanBanjar - $pengeluaranBanjar;

    //     return [
    //         Stat::make('Total Kamar', number_format($totalKamar, 0, ',', '.'))
    //             ->description('Kamar kost terdata')
    //             ->descriptionIcon(Heroicon::OutlinedHome)
    //             ->icon(Heroicon::OutlinedBuildingOffice2)
    //             ->color('primary')
    //             ->extraAttributes([
    //                 'class' => 'bg-primary-50 dark:bg-primary-950/30 border border-primary-100 dark:border-primary-900 p-2 sm:p-4',
    //             ]),

    //         Stat::make('Kosong', number_format($kamarKosong, 0, ',', '.'))
    //             ->description('Kamar tersedia')
    //             ->descriptionIcon(Heroicon::OutlinedCheckCircle)
    //             ->icon(Heroicon::OutlinedKey)
    //             ->color('success')
    //             ->extraAttributes([
    //                 'class' => 'bg-success-50 dark:bg-success-950/30 border border-success-100 dark:border-success-900 p-2 sm:p-4',
    //             ]),

    //         Stat::make('Terisi', number_format($kamarTerisi, 0, ',', '.'))
    //             ->description('Kamar ditempati')
    //             ->descriptionIcon(Heroicon::OutlinedUserGroup)
    //             ->icon(Heroicon::OutlinedUsers)
    //             ->color('warning')
    //             ->extraAttributes([
    //                 'class' => 'bg-warning-50 dark:bg-warning-950/30 border border-warning-100 dark:border-warning-900 p-2 sm:p-4',
    //             ]),

    //         Stat::make('Tagihan Kost', 'Rp ' . number_format($totalTagihanKost, 0, ',', '.'))
    //             ->description('Total tagihan')
    //             ->descriptionIcon(Heroicon::OutlinedDocumentCurrencyDollar)
    //             ->icon(Heroicon::OutlinedBanknotes)
    //             ->color('primary')
    //             ->extraAttributes([
    //                 'class' => 'bg-primary-50 dark:bg-primary-950/30 border border-primary-100 dark:border-primary-900 p-2 sm:p-4',
    //             ]),

    //         Stat::make('Pembayaran Kost', 'Rp ' . number_format($totalPembayaranKost, 0, ',', '.'))
    //             ->description('Pembayaran masuk')
    //             ->descriptionIcon(Heroicon::OutlinedCheckCircle)
    //             ->icon(Heroicon::OutlinedCreditCard)
    //             ->color('success')
    //             ->extraAttributes([
    //                 'class' => 'bg-success-50 dark:bg-success-950/30 border border-success-100 dark:border-success-900 p-2 sm:p-4',
    //             ]),

    //         Stat::make('Tunggakan Kost', 'Rp ' . number_format($totalTunggakanKost, 0, ',', '.'))
    //             ->description('Belum lunas')
    //             ->descriptionIcon(Heroicon::OutlinedExclamationCircle)
    //             ->icon(Heroicon::OutlinedClock)
    //             ->color('danger')
    //             ->extraAttributes([
    //                 'class' => 'bg-danger-50 dark:bg-danger-950/30 border border-danger-100 dark:border-danger-900 p-2 sm:p-4',
    //             ]),

    //         Stat::make('Pemasukan Banjar', 'Rp ' . number_format($pemasukanBanjar, 0, ',', '.'))
    //             ->description('Total masuk')
    //             ->descriptionIcon(Heroicon::OutlinedArrowDownCircle)
    //             ->icon(Heroicon::OutlinedWallet)
    //             ->color('success')
    //             ->extraAttributes([
    //                 'class' => 'bg-success-50 dark:bg-success-950/30 border border-success-100 dark:border-success-900 p-2 sm:p-4',
    //             ]),

    //         Stat::make('Pengeluaran Banjar', 'Rp ' . number_format($pengeluaranBanjar, 0, ',', '.'))
    //             ->description('Total keluar')
    //             ->descriptionIcon(Heroicon::OutlinedArrowUpCircle)
    //             ->icon(Heroicon::OutlinedShoppingBag)
    //             ->color('danger')
    //             ->extraAttributes([
    //                 'class' => 'bg-danger-50 dark:bg-danger-950/30 border border-danger-100 dark:border-danger-900 p-2 sm:p-4',
    //             ]),

    //         Stat::make('Saldo Banjar', 'Rp ' . number_format($saldoBanjar, 0, ',', '.'))
    //             ->description('Sisa dana')
    //             ->descriptionIcon(Heroicon::OutlinedScale)
    //             ->icon(Heroicon::OutlinedBanknotes)
    //             ->color($saldoBanjar >= 0 ? 'primary' : 'danger')
    //             ->extraAttributes([
    //                 'class' => 'bg-primary-50 dark:bg-primary-950/30 border border-primary-100 dark:border-primary-900 p-2 sm:p-4',
    //             ]),
    //     ];
    // }
    // protected function getStats(): array
    // {
    //     // Existing code...

    //     // Saldo Banjar - Pemasukan dan Pengeluaran
    //     // $pemasukanBanjar = TransaksiBanjar::query()
    //     //     ->where('tipe', 'pemasukan')
    //     //     ->sum('nominal');

    //     // $pengeluaranBanjar = TransaksiBanjar::query()
    //     //     ->where('tipe', 'pengeluaran')
    //     //     ->sum('nominal');


    //     $saldoDepositoLPD = 
    //         TransaksiBanjar::query()
    //             ->where('kategori_dana_banjar_id', 1) // Deposito LPD category ID
    //             ->where('tipe', 'kas-awal') // Pemasukan for Deposito LPD
    //             ->sum('nominal') 
    //         +
    //         TransaksiBanjar::query()
    //             ->where('kategori_dana_banjar_id', 1) // Deposito LPD category ID
    //             ->where('tipe', 'pemasukan') // Pemasukan for Deposito LPD
    //             ->sum('nominal') 
    //         - TransaksiBanjar::query()
    //             ->where('kategori_dana_banjar_id', 1) // Deposito LPD category ID
    //             ->where('tipe', 'pengeluaran') // Pengeluaran for Deposito LPD
    //             ->sum('nominal');

    //     $saldoTabunganLPD = 
    //         TransaksiBanjar::query()
    //             ->where('kategori_dana_banjar_id', 2) // Deposito LPD category ID
    //             ->where('tipe', 'kas-awal') // Pemasukan for Deposito LPD
    //             ->sum('nominal') 
    //         +
    //         TransaksiBanjar::query()
    //             ->where('kategori_dana_banjar_id', 2) // Tabungan LPD category ID
    //             ->where('tipe', 'pemasukan') // Pemasukan for Tabungan LPD
    //             ->sum('nominal')
    //         - TransaksiBanjar::query()
    //             ->where('kategori_dana_banjar_id', 2) // Tabungan LPD category ID
    //             ->where('tipe', 'pengeluaran') // Pengeluaran for Tabungan LPD
    //             ->sum('nominal');

    //     $saldoDanaCashBanjar = 
    //         TransaksiBanjar::query()
    //             ->where('kategori_dana_banjar_id', 7) // Deposito LPD category ID
    //             ->where('tipe', 'kas-awal') // Pemasukan for Deposito LPD
    //             ->sum('nominal') 
    //         +
    //         TransaksiBanjar::query()
    //             ->where('kategori_dana_banjar_id', 7) // Dana Cash category ID
    //             ->where('tipe', 'pemasukan') // Pemasukan for Dana Cash
    //             ->sum('nominal')
    //         - TransaksiBanjar::query()
    //             ->where('kategori_dana_banjar_id', 7) // Dana Cash category ID
    //             ->where('tipe', 'pengeluaran') // Pengeluaran for Dana Cash
    //             ->sum('nominal');

    //     // Saldo Prajuru
    //     $saldoKasPrajuru = 
    //         TransaksiBanjar::query()
    //             ->where('kategori_dana_banjar_id', 8) // Deposito LPD category ID
    //             ->where('tipe', 'kas-awal') // Pemasukan for Deposito LPD
    //             ->sum('nominal') 
    //         +
    //         TransaksiBanjar::query()
    //             ->where('kategori_dana_banjar_id', 8) // Kas Prajuru category ID
    //             ->where('tipe', 'pemasukan') // Pemasukan for Kas Prajuru
    //             ->sum('nominal')
    //         - TransaksiBanjar::query()
    //             ->where('kategori_dana_banjar_id', 8) // Kas Prajuru category ID
    //             ->where('tipe', 'pengeluaran') // Pengeluaran for Kas Prajuru
    //             ->sum('nominal');

    //     $saldoBanjar = $saldoDanaCashBanjar + $saldoDepositoLPD + $saldoTabunganLPD;
    //     $saldoDanaCash = $saldoDanaCashBanjar + $saldoKasPrajuru;


    //     return [
    //         // Existing Stat widgets...

    //         // Stat::make('Saldo Kas Banjar', 'Rp ' . number_format($saldoBanjar, 0, ',', '.'))
    //         //     ->description('Saldo total Banjar')
    //         //     ->descriptionIcon(Heroicon::OutlinedScale)
    //         //     ->icon(Heroicon::OutlinedBanknotes)
    //         //     ->color($saldoBanjar >= 0 ? 'primary' : 'danger')
    //         //     ->extraAttributes([
    //         //         'class' => 'bg-primary-50 dark:bg-primary-950/30 border border-primary-100 dark:border-primary-900 p-2 sm:p-4',
    //         //     ]),
                
    //         // Stat::make('Saldo Kas Prajuru', 'Rp ' . number_format($saldoKasPrajuru, 0, ',', '.'))
    //         //     ->description('Saldo Kas Prajuru')
    //         //     ->descriptionIcon(Heroicon::OutlinedScale)
    //         //     ->icon(Heroicon::OutlinedBanknotes)                
    //         //     ->color($saldoBanjar >= 0 ? 'primary' : 'danger')
    //         //     ->extraAttributes([
    //         //         'class' => 'bg-danger-50 dark:bg-danger-950/30 border border-danger-100 dark:border-danger-900 p-2 sm:p-4',
    //         //     ]),

            
    //     ];
    // }
}