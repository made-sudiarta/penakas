<?php

namespace App\Filament\Resources\TransaksiBanjars\Widgets;

use App\Models\PeriodeBanjar;
use App\Models\TransaksiBanjar;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TransaksiBanjarStats extends StatsOverviewWidget
{
    protected ?string $description = 'Statistik pemasukan, pengeluaran, dan saldo dana banjar.';

    protected function getColumns(): int|array
    {
        return [
            'default' => 1,
            'md' => 4,
        ];
    }

    protected function getHeading(): ?string
    {
        $periode = PeriodeBanjar::query()
            ->where('is_active', true)
            ->first();

        return 'Ringkasan Transaksi - ' . ($periode?->nama ?? 'Tidak Ada Periode Aktif');
    }

    protected function getSaldoKategori(int $kategoriId): float
    {
        $periodeAktifId = PeriodeBanjar::query()
            ->where('is_active', true)
            ->value('id');

        if (! $periodeAktifId) {
            return 0;
        }

        $query = TransaksiBanjar::query()
            ->where('periode_banjar_id', $periodeAktifId)
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
        $depositoLPD = $this->getSaldoKategori(1);
        $tabunganLPD = $this->getSaldoKategori(2);
        $danaCash    = $this->getSaldoKategori(7);
        $kasPrajuru  = $this->getSaldoKategori(8);

        return [
            Stat::make(
                'Deposito LPD',
                'Rp ' . number_format($depositoLPD, 0, ',', '.')
            )
                ->description('Saldo Deposito')
                ->descriptionIcon(Heroicon::OutlinedBanknotes)
                ->icon(Heroicon::OutlinedBanknotes)
                ->color($depositoLPD >= 0 ? 'success' : 'danger'),

            Stat::make(
                'Tabungan LPD',
                'Rp ' . number_format($tabunganLPD, 0, ',', '.')
            )
                ->description('Saldo Tabungan')
                ->descriptionIcon(Heroicon::OutlinedWallet)
                ->icon(Heroicon::OutlinedWallet)
                ->color($tabunganLPD >= 0 ? 'success' : 'danger'),

            Stat::make(
                'Dana Cash',
                'Rp ' . number_format($danaCash, 0, ',', '.')
            )
                ->description('Saldo Dana Cash')
                ->descriptionIcon(Heroicon::OutlinedScale)
                ->icon(Heroicon::OutlinedWallet)
                ->color($danaCash >= 0 ? 'success' : 'danger'),

            Stat::make(
                'Kas Prajuru',
                'Rp ' . number_format($kasPrajuru, 0, ',', '.')
            )
                ->description('Saldo Kas Prajuru')
                ->descriptionIcon(Heroicon::OutlinedScale)
                ->icon(Heroicon::OutlinedWallet)
                ->color($kasPrajuru >= 0 ? 'success' : 'danger'),
        ];
    }
}