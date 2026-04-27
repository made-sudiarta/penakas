<?php

namespace App\Filament\Pages;

use App\Models\KategoriDanaBanjar;
use App\Models\TransaksiBanjar;
use BackedEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use UnitEnum;

class LaporanBanjar extends Page implements HasTable, HasForms
{
    use InteractsWithTable;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartPie;

    protected static string|UnitEnum|null $navigationGroup = 'Laporan';

    protected static ?string $navigationLabel = 'Laporan Banjar';

    protected static ?string $title = 'Laporan Banjar';

    protected static ?int $navigationSort = 2;

    protected string $view = 'filament.pages.laporan-banjar';

    public ?int $kategori_dana_banjar_id = null;

    public ?int $bulan = null;

    public ?int $tahun = null;

    public function mount(): void
    {
        $this->bulan = (int) now()->format('n');
        $this->tahun = (int) now()->format('Y');
    }

    public function updatedKategoriDanaBanjarId(): void
    {
        $this->resetTable();
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
                    ->description('Pilih kategori dana dan periode laporan Banjar.')
                    ->schema([
                        Select::make('kategori_dana_banjar_id')
                            ->label('Kategori Dana')
                            ->options(
                                KategoriDanaBanjar::query()
                                    ->orderBy('nama')
                                    ->pluck('nama', 'id')
                                    ->toArray()
                            )
                            ->placeholder('Semua Kategori')
                            ->native(false)
                            ->live()
                            ->afterStateUpdated(fn () => $this->resetTable()),

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
                        'md' => 3,
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getTransaksiQuery())
            ->columns([
                TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('kategoriDanaBanjar.nama')
                    ->label('Kategori')
                    ->searchable()
                    ->sortable()
                    ->placeholder('-'),

                TextColumn::make('judul')
                    ->label('Judul')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('tipe')
                    ->label('Tipe')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pemasukan' => 'Pemasukan',
                        'pengeluaran' => 'Pengeluaran',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'pemasukan' => 'success',
                        'pengeluaran' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('nominal')
                    ->label('Nominal')
                    ->money('IDR')
                    ->sortable(),

                ImageColumn::make('foto_nota')
                    ->label('Nota')
                    ->disk('public')
                    ->square()
                    ->toggleable(),
            ])
            ->defaultSort('tanggal', 'desc');
    }

    public function getTotalPemasukanProperty(): float
    {
        return (float) $this->getTransaksiQuery()
            ->where('tipe', 'pemasukan')
            ->sum('nominal');
    }

    public function getTotalPengeluaranProperty(): float
    {
        return (float) $this->getTransaksiQuery()
            ->where('tipe', 'pengeluaran')
            ->sum('nominal');
    }

    public function getSaldoProperty(): float
    {
        return $this->totalPemasukan - $this->totalPengeluaran;
    }

    protected function getTransaksiQuery()
    {
        return TransaksiBanjar::query()
            ->with('kategoriDanaBanjar')
            ->when(
                $this->kategori_dana_banjar_id,
                fn ($query) => $query->where('kategori_dana_banjar_id', $this->kategori_dana_banjar_id)
            )
            ->whereYear('tanggal', (int) $this->tahun)
            ->whereMonth('tanggal', (int) $this->bulan);
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