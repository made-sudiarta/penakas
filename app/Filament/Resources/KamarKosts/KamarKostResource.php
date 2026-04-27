<?php

namespace App\Filament\Resources\KamarKosts;

use App\Filament\Resources\KamarKosts\Pages\CreateKamarKost;
use App\Filament\Resources\KamarKosts\Pages\EditKamarKost;
use App\Filament\Resources\KamarKosts\Pages\ListKamarKosts;
use App\Filament\Resources\KamarKosts\Schemas\KamarKostForm;
use App\Filament\Resources\KamarKosts\Tables\KamarKostsTable;
use App\Models\KamarKost;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class KamarKostResource extends Resource
{
    protected static ?string $model = KamarKost::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHome;

    protected static string|UnitEnum|null $navigationGroup = 'Rumah Kos';

    protected static ?string $navigationLabel = 'Kamar Kost';

    protected static ?string $modelLabel = 'Kamar Kost';

    protected static ?string $pluralModelLabel = 'Kamar Kost';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'nama_kamar';

    public static function form(Schema $schema): Schema
    {
        return KamarKostForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KamarKostsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListKamarKosts::route('/'),
            'create' => CreateKamarKost::route('/create'),
            'edit' => EditKamarKost::route('/{record}/edit'),
        ];
    }
}