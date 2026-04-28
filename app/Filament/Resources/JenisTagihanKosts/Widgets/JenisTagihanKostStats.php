<?php

namespace App\Filament\Resources\JenisTagihanKosts\Widgets;

use App\Models\JenisTagihanKost;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class JenisTagihanKostStats extends StatsOverviewWidget
{
    protected ?string $heading = 'Ringkasan Jenis Tagihan';

    protected ?string $description = 'Statistik master tagihan kost.';

    protected function getColumns(): int|array
    {
        return [
            'default' => 2,
            'md' => 3,
        ];
    }

    protected function getStats(): array
    {
        $total = JenisTagihanKost::count();

        $aktif = JenisTagihanKost::query()
            ->where('is_active', true)
            ->count();

        $bulanan = JenisTagihanKost::query()
            ->where('is_bulanan', true)
            ->count();

        return [
            Stat::make('Total', number_format($total, 0, ',', '.'))
                ->description('Semua')
                ->descriptionIcon(Heroicon::OutlinedClipboardDocumentList)
                ->icon(Heroicon::OutlinedDocumentText)
                ->color('primary')
                ->extraAttributes([
                    'class' => 'bg-primary-50 dark:bg-primary-950/30 border border-primary-100 dark:border-primary-900 p-2 sm:p-4',
                ]),

            Stat::make('Aktif', number_format($aktif, 0, ',', '.'))
                ->description('Digunakan')
                ->descriptionIcon(Heroicon::OutlinedCheckCircle)
                ->icon(Heroicon::OutlinedCheckBadge)
                ->color('success')
                ->extraAttributes([
                    'class' => 'bg-success-50 dark:bg-success-950/30 border border-success-100 dark:border-success-900 p-2 sm:p-4',
                ]),

            Stat::make('Bulanan', number_format($bulanan, 0, ',', '.'))
                ->description('Rutin')
                ->descriptionIcon(Heroicon::OutlinedCalendarDays)
                ->icon(Heroicon::OutlinedArrowPath)
                ->color('warning')
                ->extraAttributes([
                    'class' => 'bg-warning-50 dark:bg-warning-950/30 border border-warning-100 dark:border-warning-900 p-2 sm:p-4',
                ]),
        ];
    }
}