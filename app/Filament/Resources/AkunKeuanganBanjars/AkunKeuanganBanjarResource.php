<?php

namespace App\Filament\Resources\AkunKeuanganBanjars;

use App\Filament\Resources\AkunKeuanganBanjars\Pages\CreateAkunKeuanganBanjar;
use App\Filament\Resources\AkunKeuanganBanjars\Pages\EditAkunKeuanganBanjar;
use App\Filament\Resources\AkunKeuanganBanjars\Pages\ListAkunKeuanganBanjars;
use App\Filament\Resources\AkunKeuanganBanjars\Pages\ViewAkunKeuanganBanjar;
use App\Filament\Resources\AkunKeuanganBanjars\Schemas\AkunKeuanganBanjarForm;
use App\Filament\Resources\AkunKeuanganBanjars\Schemas\AkunKeuanganBanjarInfolist;
use App\Filament\Resources\AkunKeuanganBanjars\Tables\AkunKeuanganBanjarsTable;
use App\Models\AkunKeuanganBanjar;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AkunKeuanganBanjarResource extends Resource
{
    protected static ?string $model = AkunKeuanganBanjar::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    // protected static ?string $recordTitleAttribute = 'AkunKeuanganBanjar';
    protected static string|UnitEnum|null $navigationGroup = 'Banjar';

    protected static ?string $navigationLabel = 'Akun Keuangan Banjar';

    protected static ?string $modelLabel = 'Akun Keuangan Banjar';

    protected static ?string $pluralModelLabel = 'Akun Keuangan Banjar';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return AkunKeuanganBanjarForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AkunKeuanganBanjarInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AkunKeuanganBanjarsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAkunKeuanganBanjars::route('/'),
            'create' => CreateAkunKeuanganBanjar::route('/create'),
            'view' => ViewAkunKeuanganBanjar::route('/{record}'),
            'edit' => EditAkunKeuanganBanjar::route('/{record}/edit'),
        ];
    }
}
