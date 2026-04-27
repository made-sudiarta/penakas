<?php

namespace App\Filament\Resources\KamarKosts\Widgets;

use App\Models\KamarKost;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class KamarKostStats extends StatsOverviewWidget
{
    protected ?string $heading = 'Ringkasan Kamar Kost';

    protected ?string $description = 'Statistik jumlah kamar berdasarkan status terbaru.';

    protected function getColumns(): int|array
    {
        return [
            'default' => 3,
            'md' => 3,
        ];
    }

    protected function getStats(): array
    {
        $totalKamar = KamarKost::count();

        $kamarKosong = KamarKost::query()
            ->where('status', 'kosong')
            ->count();

        $kamarTerisi = KamarKost::query()
            ->where('status', 'terisi')
            ->count();

        return [
            Stat::make('Total', number_format($totalKamar, 0, ',', '.'))
                ->description('Semua')
                ->descriptionIcon(Heroicon::OutlinedHome)
                ->icon(Heroicon::OutlinedBuildingOffice2)
                ->color('primary')
                ->extraAttributes([
                    'class' => 'bg-primary-50 dark:bg-primary-950/30 border border-primary-100 dark:border-primary-900 p-2 sm:p-4',
                ]),

            Stat::make('Kosong', number_format($kamarKosong, 0, ',', '.'))
                ->description('Tersedia')
                ->descriptionIcon(Heroicon::OutlinedCheckCircle)
                ->icon(Heroicon::OutlinedKey)
                ->color('success')
                ->extraAttributes([
                    'class' => 'bg-success-50 dark:bg-success-950/30 border border-success-100 dark:border-success-900 p-2 sm:p-4',
                ]),

            Stat::make('Terisi', number_format($kamarTerisi, 0, ',', '.'))
                ->description('Ditempati')
                ->descriptionIcon(Heroicon::OutlinedUserGroup)
                ->icon(Heroicon::OutlinedUsers)
                ->color('warning')
                ->extraAttributes([
                    'class' => 'bg-warning-50 dark:bg-warning-950/30 border border-warning-100 dark:border-warning-900 p-2 sm:p-4',
                ]),
        ];
    }
}