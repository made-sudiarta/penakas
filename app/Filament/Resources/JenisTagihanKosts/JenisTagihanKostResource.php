<?php

namespace App\Filament\Resources\JenisTagihanKosts;

use App\Filament\Resources\JenisTagihanKosts\Pages\CreateJenisTagihanKost;
use App\Filament\Resources\JenisTagihanKosts\Pages\EditJenisTagihanKost;
use App\Filament\Resources\JenisTagihanKosts\Pages\ListJenisTagihanKosts;
use App\Filament\Resources\JenisTagihanKosts\Schemas\JenisTagihanKostForm;
use App\Filament\Resources\JenisTagihanKosts\Tables\JenisTagihanKostsTable;
use App\Models\JenisTagihanKost;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class JenisTagihanKostResource extends Resource
{
    protected static ?string $model = JenisTagihanKost::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static string|UnitEnum|null $navigationGroup = 'Rumah Kos';

    protected static ?string $navigationLabel = 'Jenis Tagihan';

    protected static ?string $modelLabel = 'Jenis Tagihan';

    protected static ?string $pluralModelLabel = 'Jenis Tagihan';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'nama';

    public static function form(Schema $schema): Schema
    {
        return JenisTagihanKostForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return JenisTagihanKostsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListJenisTagihanKosts::route('/'),
            'create' => CreateJenisTagihanKost::route('/create'),
            'edit' => EditJenisTagihanKost::route('/{record}/edit'),
        ];
    }
}