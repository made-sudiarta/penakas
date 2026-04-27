<?php

namespace App\Filament\Resources\Penghunis\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PenghuniForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Penghuni')
                    ->description('Lengkapi data penghuni dan kamar yang ditempati.')
                    ->schema([
                        TextInput::make('nama')
                            ->label('Nama Penghuni')
                            ->placeholder('Contoh: Made Wijaya')
                            ->required()
                            ->maxLength(255)
                            ->autofocus(),

                        Select::make('kamar_kost_id')
                            ->label('Kamar Kost')
                            ->relationship(
                                name: 'kamarKost',
                                titleAttribute: 'nama_kamar',
                            )
                            ->searchable()
                            ->preload()
                            ->required()
                            ->helperText('Pilih kamar yang ditempati.'),

                        TextInput::make('no_hp')
                            ->label('No. HP')
                            ->placeholder('Contoh: 081234567890')
                            ->tel()
                            ->maxLength(255),

                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'aktif' => 'Aktif',
                                'keluar' => 'Keluar',
                            ])
                            ->native(false)
                            ->default('aktif')
                            ->required(),

                        DatePicker::make('tanggal_masuk')
                            ->label('Tanggal Masuk')
                            ->native(false)
                            ->displayFormat('d M Y'),

                        DatePicker::make('tanggal_keluar')
                            ->label('Tanggal Keluar')
                            ->native(false)
                            ->displayFormat('d M Y')
                            ->visible(fn ($get) => $get('status') === 'keluar'),

                        Textarea::make('alamat')
                            ->label('Alamat')
                            ->placeholder('Alamat asal penghuni')
                            ->rows(3)
                            ->columnSpanFull(),

                        Textarea::make('catatan')
                            ->label('Catatan')
                            ->placeholder('Catatan tambahan untuk penghuni ini')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                        'xl' => 3,
                    ])
                    ->columnSpanFull(),
            ]);
    }
}