<?php

namespace App\Filament\Resources\TagihanKosts;

use App\Filament\Resources\TagihanKosts\Pages\CreateTagihanKost;
use App\Filament\Resources\TagihanKosts\Pages\EditTagihanKost;
use App\Filament\Resources\TagihanKosts\Pages\ListTagihanKosts;
use App\Filament\Resources\TagihanKosts\Schemas\TagihanKostForm;
use App\Filament\Resources\TagihanKosts\Tables\TagihanKostsTable;
use App\Models\TagihanKost;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class TagihanKostResource extends Resource
{
    protected static ?string $model = TagihanKost::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBanknotes;

    protected static string|UnitEnum|null $navigationGroup = 'Rumah Kos';

    protected static ?string $navigationLabel = 'Tagihan Kost';

    protected static ?string $modelLabel = 'Tagihan Kost';

    protected static ?string $pluralModelLabel = 'Tagihan Kost';

    protected static ?int $navigationSort = 4;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return TagihanKostForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TagihanKostsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTagihanKosts::route('/'),
            'create' => CreateTagihanKost::route('/create'),
            'edit' => EditTagihanKost::route('/{record}/edit'),
        ];
    }
}