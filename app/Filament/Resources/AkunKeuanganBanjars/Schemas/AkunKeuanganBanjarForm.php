<?php

namespace App\Filament\Resources\AkunKeuanganBanjars\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AkunKeuanganBanjarForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Akun')
                    ->schema([
                        TextInput::make('kode')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(20),

                        TextInput::make('nama')
                            ->required()
                            ->maxLength(255),

                        Select::make('tipe')
                            ->options([
                                'aset' => 'Aset',
                                'pendapatan' => 'Pendapatan',
                                'beban' => 'Beban',
                                'modal' => 'Modal',
                            ])
                            ->required(),

                        Toggle::make('is_active')
                            ->default(true),
                    ]),
            ]);
    }
}