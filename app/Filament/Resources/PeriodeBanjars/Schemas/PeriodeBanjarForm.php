<?php

namespace App\Filament\Resources\PeriodeBanjars\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PeriodeBanjarForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->required(),

                DatePicker::make('tanggal_mulai')
                    ->required(),

                DatePicker::make('tanggal_selesai'),

                Toggle::make('is_active'),

                Toggle::make('is_closed'),

                Textarea::make('keterangan')
                    ->columnSpanFull(),
            ]);
    }
}