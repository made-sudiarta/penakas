<?php

namespace App\Filament\Resources\KategoriDanaBanjars\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class KategoriDanaBanjarForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Kategori Dana')
                    ->description('Kelola kategori dana seperti Dana Banjar dan Dana Prajuru.')
                    ->schema([
                        TextInput::make('nama')
                            ->label('Nama Kategori')
                            ->placeholder('Contoh: Dana Banjar')
                            ->required()
                            ->maxLength(255)
                            ->autofocus(),

                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->helperText('Nonaktifkan jika kategori ini tidak digunakan lagi.')
                            ->default(true)
                            ->inline(false),

                        Textarea::make('deskripsi')
                            ->label('Deskripsi')
                            ->placeholder('Keterangan tambahan kategori dana')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ])
                    ->columnSpanFull(),
            ]);
    }
}