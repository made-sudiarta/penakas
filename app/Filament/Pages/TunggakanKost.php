<?php

namespace App\Filament\Pages;

use App\Models\TagihanKost;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use UnitEnum;

class TunggakanKost extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedExclamationTriangle;

    protected static string|UnitEnum|null $navigationGroup = 'Rumah Kos';

    protected static ?string $navigationLabel = 'Tunggakan Kost';

    protected static ?string $title = 'Tunggakan Kost';

    protected static ?int $navigationSort = 6;

    protected string $view = 'filament.pages.tunggakan-kost';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                TagihanKost::query()
                    ->with(['penghuni', 'kamarKost'])
                    ->whereIn('status', ['belum_lunas', 'sebagian'])
                    ->whereDate('tanggal_jatuh_tempo', '<', now())
            )
            ->columns([
                TextColumn::make('penghuni.nama')
                    ->label('Penghuni')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('kamarKost.nama_kamar')
                    ->label('Kamar')
                    ->searchable()
                    ->sortable()
                    ->placeholder('-'),

                TextColumn::make('periode')
                    ->label('Periode')
                    ->state(function ($record): string {
                        $bulan = [
                            1 => 'Januari',
                            2 => 'Februari',
                            3 => 'Maret',
                            4 => 'April',
                            5 => 'Mei',
                            6 => 'Juni',
                            7 => 'Juli',
                            8 => 'Agustus',
                            9 => 'September',
                            10 => 'Oktober',
                            11 => 'November',
                            12 => 'Desember',
                        ];

                        return ($bulan[$record->bulan] ?? $record->bulan) . ' ' . $record->tahun;
                    }),

                TextColumn::make('tanggal_jatuh_tempo')
                    ->label('Jatuh Tempo')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('total_tagihan')
                    ->label('Tagihan')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('total_dibayar')
                    ->label('Dibayar')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('sisa')
                    ->label('Sisa')
                    ->state(fn ($record) => max(0, $record->total_tagihan - $record->total_dibayar))
                    ->money('IDR'),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'belum_lunas' => 'Belum Lunas',
                        'sebagian' => 'Sebagian',
                        'lunas' => 'Lunas',
                        'dibatalkan' => 'Dibatalkan',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'belum_lunas' => 'danger',
                        'sebagian' => 'warning',
                        'lunas' => 'success',
                        'dibatalkan' => 'gray',
                        default => 'gray',
                    }),
            ])
            ->defaultSort('tanggal_jatuh_tempo', 'asc');
    }
}