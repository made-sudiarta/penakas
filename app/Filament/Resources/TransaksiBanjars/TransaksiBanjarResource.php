<?php

namespace App\Filament\Resources\TransaksiBanjars;

use App\Filament\Resources\TransaksiBanjars\Pages\CreateTransaksiBanjar;
use App\Filament\Resources\TransaksiBanjars\Pages\EditTransaksiBanjar;
use App\Filament\Resources\TransaksiBanjars\Pages\ListTransaksiBanjars;
use App\Filament\Resources\TransaksiBanjars\Schemas\TransaksiBanjarForm;
use App\Filament\Resources\TransaksiBanjars\Tables\TransaksiBanjarsTable;
use App\Models\TransaksiBanjar;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use BackedEnum;
use UnitEnum;

class TransaksiBanjarResource extends Resource
{
    protected static ?string $model = TransaksiBanjar::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedReceiptPercent;

    protected static string|UnitEnum|null $navigationGroup = 'Banjar';

    protected static ?string $navigationLabel = 'Transaksi Banjar';

    protected static ?string $modelLabel = 'Transaksi Banjar';

    protected static ?string $pluralModelLabel = 'Transaksi Banjar';

    protected static ?int $navigationSort = 4;

    protected static ?string $recordTitleAttribute = 'judul';

    public static function form(Schema $schema): Schema
    {
        return TransaksiBanjarForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TransaksiBanjarsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTransaksiBanjars::route('/'),
            'create' => CreateTransaksiBanjar::route('/create'),
            'edit' => EditTransaksiBanjar::route('/{record}/edit'),
        ];
    }
    
}