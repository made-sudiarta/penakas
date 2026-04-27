<?php

namespace App\Filament\Resources\KategoriDanaBanjars;

use App\Filament\Resources\KategoriDanaBanjars\Pages\CreateKategoriDanaBanjar;
use App\Filament\Resources\KategoriDanaBanjars\Pages\EditKategoriDanaBanjar;
use App\Filament\Resources\KategoriDanaBanjars\Pages\ListKategoriDanaBanjars;
use App\Filament\Resources\KategoriDanaBanjars\Schemas\KategoriDanaBanjarForm;
use App\Filament\Resources\KategoriDanaBanjars\Tables\KategoriDanaBanjarsTable;
use App\Models\KategoriDanaBanjar;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class KategoriDanaBanjarResource extends Resource
{
    protected static ?string $model = KategoriDanaBanjar::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedFolder;

    protected static string|UnitEnum|null $navigationGroup = 'Banjar';

    protected static ?string $navigationLabel = 'Kategori Dana';

    protected static ?string $modelLabel = 'Kategori Dana';

    protected static ?string $pluralModelLabel = 'Kategori Dana';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'nama';

    public static function form(Schema $schema): Schema
    {
        return KategoriDanaBanjarForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KategoriDanaBanjarsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListKategoriDanaBanjars::route('/'),
            'create' => CreateKategoriDanaBanjar::route('/create'),
            'edit' => EditKategoriDanaBanjar::route('/{record}/edit'),
        ];
    }
}