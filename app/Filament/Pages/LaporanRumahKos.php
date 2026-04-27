<?php

namespace App\Filament\Pages;

use App\Models\PembayaranKost;
use App\Models\TagihanKost;
use BackedEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use UnitEnum;

class LaporanRumahKos extends Page implements HasTable, HasForms
{
    use InteractsWithTable;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBar;

    protected static string|UnitEnum|null $navigationGroup = 'Laporan';

    protected static ?string $navigationLabel = 'Laporan Rumah Kos';

    protected static ?string $title = 'Laporan Rumah Kos';

    protected static ?int $navigationSort = 1;

    protected string $view = 'filament.pages.laporan-rumah-kos';

    public ?int $bulan = null;

    public ?int $tahun = null;

    public function mount(): void
    {
        $this->bulan = (int) now()->format('n');
        $this->tahun = (int) now()->format('Y');
    }

    public function updatedBulan(): void
    {
        $this->resetTable();
    }

    public function updatedTahun(): void
    {
        $this->resetTable();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Filter Laporan')
                    ->description('Pilih periode laporan rumah kos.')
                    ->schema([
                        Select::make('bulan')
                            ->label('Bulan')
                            ->options($this->getBulanOptions())
                            ->native(false)
                            ->live()
                            ->afterStateUpdated(fn () => $this->resetTable())
                            ->required(),

                        Select::make('tahun')
                            ->label('Tahun')
                            ->options($this->getTahunOptions())
                            ->native(false)
                            ->live()
                            ->afterStateUpdated(fn () => $this->resetTable())
                            ->required(),
                    ])
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                TagihanKost::query()
                    ->with(['penghuni', 'kamarKost'])
                    ->where('bulan', (int) $this->bulan)
                    ->where('tahun', (int) $this->tahun)
            )
            ->columns([
                TextColumn::make('penghuni.nama')
                    ->label('Penghuni')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('kamarKost.nama_kamar')
                    ->label('Kamar')
                    ->searchable()
                    ->sortable()
                    ->placeholder('-'),

                TextColumn::make('periode')
                    ->label('Periode')
                    ->state(function ($record): string {
                        return $this->getBulanOptions()[$record->bulan] . ' ' . $record->tahun;
                    }),

                TextColumn::make('total_tagihan')
                    ->label('Tagihan')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('total_dibayar')
                    ->label('Dibayar')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('sisa')
                    ->label('Sisa')
                    ->state(fn ($record) => max(0, $record->total_tagihan - $record->total_dibayar))
                    ->money('IDR'),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'belum_lunas' => 'Belum Lunas',
                        'sebagian' => 'Sebagian',
                        'lunas' => 'Lunas',
                        'dibatalkan' => 'Dibatalkan',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'belum_lunas' => 'danger',
                        'sebagian' => 'warning',
                        'lunas' => 'success',
                        'dibatalkan' => 'gray',
                        default => 'gray',
                    }),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public function getTotalTagihanProperty(): float
    {
        return (float) TagihanKost::query()
            ->where('bulan', (int) $this->bulan)
            ->where('tahun', (int) $this->tahun)
            ->sum('total_tagihan');
    }

    public function getTotalDibayarProperty(): float
    {
        return (float) TagihanKost::query()
            ->where('bulan', (int) $this->bulan)
            ->where('tahun', (int) $this->tahun)
            ->sum('total_dibayar');
    }

    public function getTotalTunggakanProperty(): float
    {
        return (float) TagihanKost::query()
            ->where('bulan', (int) $this->bulan)
            ->where('tahun', (int) $this->tahun)
            ->whereIn('status', ['belum_lunas', 'sebagian'])
            ->get()
            ->sum(fn (TagihanKost $tagihan) => max(0, $tagihan->total_tagihan - $tagihan->total_dibayar));
    }

    public function getTotalPembayaranMasukProperty(): float
    {
        return (float) PembayaranKost::query()
            ->whereYear('tanggal_bayar', (int) $this->tahun)
            ->whereMonth('tanggal_bayar', (int) $this->bulan)
            ->sum('jumlah_bayar');
    }

    protected function getBulanOptions(): array
    {
        return [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];
    }

    protected function getTahunOptions(): array
    {
        $tahunSekarang = (int) now()->format('Y');

        return collect(range($tahunSekarang - 5, $tahunSekarang + 1))
            ->mapWithKeys(fn ($tahun) => [$tahun => (string) $tahun])
            ->toArray();
    }
}