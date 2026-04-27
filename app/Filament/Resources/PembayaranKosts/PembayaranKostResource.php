<?php

namespace App\Filament\Resources\PembayaranKosts;

use App\Filament\Resources\PembayaranKosts\Pages\CreatePembayaranKost;
use App\Filament\Resources\PembayaranKosts\Pages\EditPembayaranKost;
use App\Filament\Resources\PembayaranKosts\Pages\ListPembayaranKosts;
use App\Filament\Resources\PembayaranKosts\Schemas\PembayaranKostForm;
use App\Filament\Resources\PembayaranKosts\Tables\PembayaranKostsTable;
use App\Models\PembayaranKost;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PembayaranKostResource extends Resource
{
    protected static ?string $model = PembayaranKost::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCreditCard;

    protected static string|UnitEnum|null $navigationGroup = 'Rumah Kos';

    protected static ?string $navigationLabel = 'Pembayaran Kost';

    protected static ?string $modelLabel = 'Pembayaran Kost';

    protected static ?string $pluralModelLabel = 'Pembayaran Kost';

    protected static ?int $navigationSort = 5;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return PembayaranKostForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PembayaranKostsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPembayaranKosts::route('/'),
            'create' => CreatePembayaranKost::route('/create'),
            'edit' => EditPembayaranKost::route('/{record}/edit'),
        ];
    }
}