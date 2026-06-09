<?php

namespace App\Filament\Resources\PeriodeBanjars;

use App\Filament\Resources\PeriodeBanjars\Pages\CreatePeriodeBanjar;
use App\Filament\Resources\PeriodeBanjars\Pages\EditPeriodeBanjar;
use App\Filament\Resources\PeriodeBanjars\Pages\ListPeriodeBanjars;
use App\Filament\Resources\PeriodeBanjars\Pages\ViewPeriodeBanjar;
use App\Filament\Resources\PeriodeBanjars\Schemas\PeriodeBanjarForm;
use App\Filament\Resources\PeriodeBanjars\Schemas\PeriodeBanjarInfolist;
use App\Filament\Resources\PeriodeBanjars\Tables\PeriodeBanjarsTable;
use App\Models\PeriodeBanjar;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PeriodeBanjarResource extends Resource
{
    protected static ?string $model = PeriodeBanjar::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    // protected static ?string $recordTitleAttribute = 'PeriodeBanjar';

    protected static string|UnitEnum|null $navigationGroup = 'Banjar';

    protected static ?string $navigationLabel = 'Periode Keuangan Banjar';

    protected static ?string $modelLabel = 'Periode Keuangan Banjar';

    protected static ?string $pluralModelLabel = 'Periode Keuangan Banjar';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return PeriodeBanjarForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PeriodeBanjarInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PeriodeBanjarsTable::configure($table);
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
            'index' => ListPeriodeBanjars::route('/'),
            'create' => CreatePeriodeBanjar::route('/create'),
            'view' => ViewPeriodeBanjar::route('/{record}'),
            'edit' => EditPeriodeBanjar::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
