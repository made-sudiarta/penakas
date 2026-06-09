<?php

namespace App\Filament\Widgets;

use App\Models\KamarKost;
use App\Models\PembayaranKost;
use App\Models\TagihanKost;
use App\Models\TransaksiBanjar;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\PeriodeBanjar;

class PenaKasOverviewBanjar extends StatsOverviewWidget
{
    protected ?string $heading = 'Banjar Adat Minggir';

    protected ?string $description = 'Rincian Dana Banjar dan Prajuru';

    protected static ?int $sort = 1;

    protected function getColumns(): int|array
    {
        return [
            'default' => 1,
            'md' => 3,
            'xl' => 3,
        ];
    }
    protected function getPeriodeAktifId(): ?int
    {
        return \App\Models\PeriodeBanjar::query()
            ->where('is_active', true)
            ->value('id');
    }

    
    protected function getSaldoKategori(int $kategoriId): float
    {
        $query = TransaksiBanjar::query()
            ->where('periode_banjar_id', $this->getPeriodeAktifId())
            ->where('kategori_dana_banjar_id', $kategoriId);

        return
            (clone $query)
                ->whereIn('tipe', ['kas-awal', 'pemasukan'])
                ->sum('nominal')
            -
            (clone $query)
                ->where('tipe', 'pengeluaran')
                ->sum('nominal');
    }
    protected function getStats(): array
    {
        

        $saldoDepositoLPD = $this->getSaldoKategori(1);
        $saldoTabunganLPD = $this->getSaldoKategori(2);
        $saldoDanaCash    = $this->getSaldoKategori(7);
        $saldoKasPrajuru  = $this->getSaldoKategori(8);

        $totalDanaBanjar =
            $saldoDepositoLPD +
            $saldoTabunganLPD +
            $saldoDanaCash;

        $totalDanaKeseluruhan =
            $totalDanaBanjar +
            $saldoKasPrajuru;

        return [

            Stat::make(
                'Deposito LPD',
                'Rp ' . number_format($saldoDepositoLPD, 0, ',', '.')
            )
                ->description('Saldo Deposito LPD')
                ->descriptionIcon(Heroicon::OutlinedBanknotes)
                ->icon(Heroicon::OutlinedBanknotes)
                ->color('primary'),

            Stat::make(
                'Tabungan LPD',
                'Rp ' . number_format($saldoTabunganLPD, 0, ',', '.')
            )
                ->description('Saldo Tabungan LPD')
                ->descriptionIcon(Heroicon::OutlinedWallet)
                ->icon(Heroicon::OutlinedWallet)
                ->color('success'),

            Stat::make(
                'Dana Cash',
                'Rp ' . number_format($saldoDanaCash, 0, ',', '.')
            )
                ->description('Saldo Dana Cash')
                ->descriptionIcon(Heroicon::OutlinedCurrencyDollar)
                ->icon(Heroicon::OutlinedCurrencyDollar)
                ->color('warning'),

            Stat::make(
                'Kas Prajuru',
                'Rp ' . number_format($saldoKasPrajuru, 0, ',', '.')
            )
                ->description('Saldo Kas Prajuru')
                ->descriptionIcon(Heroicon::OutlinedUserGroup)
                ->icon(Heroicon::OutlinedUserGroup)
                ->color('danger'),

            Stat::make(
                'Total Dana Banjar',
                'Rp ' . number_format($totalDanaBanjar, 0, ',', '.')
            )
                ->description('Dana Banjar (Tanpa Prajuru)')
                ->descriptionIcon(Heroicon::OutlinedScale)
                ->icon(Heroicon::OutlinedScale)
                ->color('success'),

            Stat::make(
                'Total Dana Keseluruhan',
                'Rp ' . number_format($totalDanaKeseluruhan, 0, ',', '.')
            )
                ->description('Banjar + Prajuru')
                ->descriptionIcon(Heroicon::OutlinedBanknotes)
                ->icon(Heroicon::OutlinedBanknotes)
                ->color('primary'),
        ];
    }
}