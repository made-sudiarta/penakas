<?php

namespace App\Filament\Resources\Penghunis\Widgets;

use App\Models\Penghuni;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PenghuniStats extends StatsOverviewWidget
{
    protected ?string $heading = 'Ringkasan Penghuni';

    protected ?string $description = 'Statistik penghuni kost berdasarkan status terbaru.';

    protected function getColumns(): int|array
    {
        return [
            'default' => 3,
            'md' => 3,
        ];
    }

    protected function getStats(): array
    {
        $totalPenghuni = Penghuni::count();

        $penghuniAktif = Penghuni::query()
            ->where('status', 'aktif')
            ->count();

        $penghuniKeluar = Penghuni::query()
            ->where('status', 'keluar')
            ->count();

        return [
            Stat::make('Total', number_format($totalPenghuni, 0, ',', '.'))
                ->description('Semua')
                ->descriptionIcon(Heroicon::OutlinedUserGroup)
                ->icon(Heroicon::OutlinedUsers)
                ->color('primary')
                ->extraAttributes([
                    'class' => 'bg-primary-50 dark:bg-primary-950/30 border border-primary-100 dark:border-primary-900 p-2 sm:p-4',
                ]),

            Stat::make('Aktif', number_format($penghuniAktif, 0, ',', '.'))
                ->description('Menghuni')
                ->descriptionIcon(Heroicon::OutlinedCheckCircle)
                ->icon(Heroicon::OutlinedUser)
                ->color('success')
                ->extraAttributes([
                    'class' => 'bg-success-50 dark:bg-success-950/30 border border-success-100 dark:border-success-900 p-2 sm:p-4',
                ]),

            Stat::make('Keluar', number_format($penghuniKeluar, 0, ',', '.'))
                ->description('Riwayat')
                ->descriptionIcon(Heroicon::OutlinedArrowRightCircle)
                ->icon(Heroicon::OutlinedUserMinus)
                ->color('danger')
                ->extraAttributes([
                    'class' => 'bg-danger-50 dark:bg-danger-950/30 border border-danger-100 dark:border-danger-900 p-2 sm:p-4',
                ]),
        ];
    }
}