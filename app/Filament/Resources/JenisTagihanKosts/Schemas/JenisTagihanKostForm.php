<?php

namespace App\Filament\Resources\JenisTagihanKosts\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class JenisTagihanKostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Jenis Tagihan')
                    ->description('Atur nama tagihan, nominal default, dan status penggunaan.')
                    ->schema([
                        TextInput::make('nama')
                            ->label('Nama Tagihan')
                            ->placeholder('Contoh: Air, Listrik, Internet')
                            ->required()
                            ->maxLength(255)
                            ->autofocus(),

                        TextInput::make('nominal_default')
                            ->label('Nominal Default')
                            ->numeric()
                            ->prefix('Rp')
                            ->placeholder('50000')
                            ->default(0)
                            ->minValue(0)
                            ->required()
                            ->helperText('Nominal ini bisa diubah saat membuat tagihan bulanan.'),

                        Toggle::make('is_bulanan')
                            ->label('Tagihan Bulanan')
                            ->helperText('Aktifkan jika tagihan ini rutin ditagihkan setiap bulan.')
                            ->default(true)
                            ->inline(false),

                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->helperText('Nonaktifkan jika jenis tagihan ini tidak digunakan lagi.')
                            ->default(true)
                            ->inline(false),
                    ])
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                        'xl' => 4,
                    ])
                    ->columnSpanFull(),
            ]);
    }
}