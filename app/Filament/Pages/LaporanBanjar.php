<?php

namespace App\Filament\Pages;

use App\Models\KategoriDanaBanjar;
use App\Models\TransaksiBanjar;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
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
use Livewire\Component;
use Filament\Actions\Action;
use UnitEnum, BackedEnum;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LaporanBanjar extends Page implements HasTable, HasForms
{
    use InteractsWithTable;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBar;

    protected static string|UnitEnum|null $navigationGroup = 'Laporan';

    protected static ?string $navigationLabel = 'Laporan Banjar';

    protected static ?string $title = 'Laporan Banjar';

    protected static ?int $navigationSort = 2;

    protected string $view = 'filament.pages.laporan-banjar';

    public ?array $kategori_dana_banjar_id = [];
    public ?string $start_date = null;
    public ?string $end_date = null;

    public function mount(): void
    {
        // Initialize properties
    }

    public function updatedStartDate(): void
    {
        // Sanitasi dan validasi data
        $this->start_date = $this->sanitizeDate($this->start_date);
        $this->resetTable();
    }

    public function updatedEndDate(): void
    {
        // Sanitasi dan validasi data
        $this->end_date = $this->sanitizeDate($this->end_date);
        $this->resetTable();
    }

    private function sanitizeDate($date): string
    {
        return htmlspecialchars(trim($date), ENT_QUOTES, 'UTF-8');
    }

    public function updatedKategoriDanaBanjarId(): void
    {
        // Validasi dan sanitasi input kategori dana banjar
        $this->kategori_dana_banjar_id = array_map(function($item) {
            return (int) $item; // Pastikan ID yang diterima adalah integer
        }, $this->kategori_dana_banjar_id);

        $this->resetTable();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('print_pdf')
                ->label('Print PDF')
                ->icon('heroicon-o-printer')
                ->color('danger')
                ->action('generatePdf'),
        ];
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
                            ->options(fn () => KategoriDanaBanjar::query()
                                ->when(
                                    filled($this->kategori_dana_banjar_id),
                                    fn ($query) => $query->whereNotIn(
                                        'id',
                                        $this->kategori_dana_banjar_id
                                    )
                                )
                                ->orderBy('nama')
                                ->pluck('nama', 'id')
                                ->toArray()
                            )
                            ->placeholder('Semua Kategori')
                            ->native(false)
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(fn () => $this->resetTable()),
                        // Filter untuk Rentang Tanggal menggunakan DatePicker
                        DatePicker::make('start_date')
                            ->label('Tanggal Mulai')
                            ->placeholder('Pilih Tanggal Mulai')
                            ->native(false)
                            ->live()
                            ->afterStateUpdated(fn () => $this->resetTable())
                            ->required(),

                        DatePicker::make('end_date')
                            ->label('Tanggal Akhir')
                            ->placeholder('Pilih Tanggal Akhir')
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

    public function generatePdf(): StreamedResponse
    {
        $data = $this->getTransaksiQuery()->get();

        if ($data->isEmpty()) {
            abort(404, 'Data tidak ditemukan');
        }

        $pdf = Pdf::loadView(
            'filament.pages.laporan-banjar-pdf',
            [
                'data' => $data,
                'totalPemasukan' => $this->totalPemasukan,
                'totalPengeluaran' => $this->totalPengeluaran,
                'saldo' => $this->saldo,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
            ]
        )->setPaper('a4', 'portrait');

        return response()->streamDownload(
            fn () => print($pdf->output()),
            'laporan-banjar.pdf'
        );
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
                $this->kategori_dana_banjar_id && count($this->kategori_dana_banjar_id) > 0,
                fn ($query) => $query->whereIn(
                    'kategori_dana_banjar_id',
                    $this->kategori_dana_banjar_id
                )
            )
            ->when(
                $this->start_date && $this->end_date,
                fn ($query) => $query->whereBetween(
                    'tanggal',
                    [$this->start_date, $this->end_date]
                )
            )

            // SORTING
            ->orderBy('tanggal', 'asc');
    }

    protected function getDateOptions(): array
    {
        $currentYear = (int) now()->format('Y');
        $currentMonth = (int) now()->format('m');

        // Generate range tanggal untuk bulan sekarang
        $daysInMonth = now()->daysInMonth;
        $days = range(1, $daysInMonth);

        return collect($days)->mapWithKeys(fn ($day) => [
            $day => $currentYear . '-' . str_pad($currentMonth, 2, '0', STR_PAD_LEFT) . '-' . str_pad($day, 2, '0', STR_PAD_LEFT),
        ])->toArray();
    }
}