<?php

namespace App\Filament\Resources\Penghunis;

use App\Filament\Resources\Penghunis\Pages\CreatePenghuni;
use App\Filament\Resources\Penghunis\Pages\EditPenghuni;
use App\Filament\Resources\Penghunis\Pages\ListPenghunis;
use App\Filament\Resources\Penghunis\Schemas\PenghuniForm;
use App\Filament\Resources\Penghunis\Tables\PenghunisTable;
use App\Models\Penghuni;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PenghuniResource extends Resource
{
    protected static ?string $model = Penghuni::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static string|UnitEnum|null $navigationGroup = 'Rumah Kos';

    protected static ?string $navigationLabel = 'Penghuni';

    protected static ?string $modelLabel = 'Penghuni';

    protected static ?string $pluralModelLabel = 'Penghuni';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'nama';

    public static function form(Schema $schema): Schema
    {
        return PenghuniForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PenghunisTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPenghunis::route('/'),
            'create' => CreatePenghuni::route('/create'),
            'edit' => EditPenghuni::route('/{record}/edit'),
        ];
    }
}