<?php

namespace App\Filament\Resources\KamarKosts\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class KamarKostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Kamar Kost')
                    ->description('Lengkapi data kamar kost yang akan dikelola.')
                    ->schema([
                        TextInput::make('nama_kamar')
                            ->label('Nama Kamar')
                            ->placeholder('Contoh: Kamar 01')
                            ->required()
                            ->maxLength(255)
                            ->autofocus(),

                        TextInput::make('nomor_kamar')
                            ->label('Nomor Kamar')
                            ->placeholder('Contoh: A-01')
                            ->maxLength(255)
                            ->helperText('Opsional, bisa diisi kode atau nomor kamar.'),

                        TextInput::make('harga_default')
                            ->label('Harga Bulanan')
                            ->numeric()
                            ->prefix('Rp')
                            ->placeholder('1000000')
                            ->default(0)
                            ->minValue(0)
                            ->required()
                            ->helperText('Harga default yang akan dipakai saat membuat tagihan.'),

                        Select::make('status')
                            ->label('Status Kamar')
                            ->options([
                                'kosong' => 'Kosong',
                                'terisi' => 'Terisi',
                                'maintenance' => 'Maintenance',
                            ])
                            ->native(false)
                            ->default('kosong')
                            ->required(),

                        Textarea::make('keterangan')
                            ->label('Keterangan')
                            ->placeholder('Contoh: Kamar dekat tangga, kamar mandi dalam, atau sedang diperbaiki.')
                            ->rows(4)
                            ->maxLength(1000)
                            ->columnSpanFull(),
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