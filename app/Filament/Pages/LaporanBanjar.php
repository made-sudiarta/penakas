<?php

namespace App\Filament\Pages;

use App\Models\PeriodeBanjar;
use App\Models\TransaksiBanjar;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
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
use Symfony\Component\HttpFoundation\StreamedResponse;
use UnitEnum;
use BackedEnum;

class LaporanBanjar extends Page implements HasTable, HasForms
{
    use InteractsWithTable;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBar;

    protected static string|UnitEnum|null $navigationGroup = 'Laporan';

    protected static ?string $navigationLabel = 'Laporan Banjar';

    protected static ?string $title = 'Laporan Banjar';

    protected static ?int $navigationSort = 2;

    protected string $view = 'filament.pages.laporan-banjar';

    public ?int $periode_banjar_id = null;

    public string $jenis_laporan = 'gabungan';

    public function mount(): void
    {
        $this->periode_banjar_id = PeriodeBanjar::query()
            ->where('is_active', true)
            ->value('id');

        $this->jenis_laporan = 'gabungan';
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
                    ->description('Pilih periode dan jenis laporan.')
                    ->schema([

                        Select::make('periode_banjar_id')
                            ->label('Periode')
                            ->options(
                                PeriodeBanjar::query()
                                    ->orderByDesc('tanggal_mulai')
                                    ->pluck('nama', 'id')
                            )
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live()
                            ->afterStateUpdated(fn () => $this->resetTable()),

                        Select::make('jenis_laporan')
                            ->label('Jenis Laporan')
                            ->options([
                                'banjar' => 'Laporan Keuangan Banjar',
                                'prajuru' => 'Laporan Keuangan Prajuru',
                                'gabungan' => 'Laporan Keuangan Banjar & Prajuru',
                            ])
                            ->native(false)
                            ->required()
                            ->live()
                            ->afterStateUpdated(fn () => $this->resetTable()),

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
            ->query($this->getTransaksiQuery())
            ->columns([
                TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('kategoriDanaBanjar.nama')
                    ->label('Kategori')
                    ->sortable(),

                TextColumn::make('judul')
                    ->label('Judul')
                    ->searchable(),

                TextColumn::make('tipe')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'kas-awal' => 'Kas Awal',
                        'pemasukan' => 'Pemasukan',
                        'pengeluaran' => 'Pengeluaran',
                        default => $state,
                    }),

                TextColumn::make('nominal')
                    ->money('IDR')
                    ->sortable(),

                ImageColumn::make('foto_nota')
                    ->label('Nota')
                    ->disk('public')
                    ->square()
                    ->toggleable(),
            ])
            ->defaultSort('tanggal', 'asc');
    }

    protected function getKategoriIds(): array
    {
        return match ($this->jenis_laporan) {

            'banjar' => [1, 2, 7],

            'prajuru' => [8],

            default => [1, 2, 7, 8],
        };
    }

    protected function getJudulLaporan(): string
    {
        return match ($this->jenis_laporan) {

            'banjar' =>
                'Laporan Keuangan Banjar',

            'prajuru' =>
                'Laporan Keuangan Prajuru',

            default =>
                'Laporan Keuangan Banjar dan Prajuru',
        };
    }

    public function generatePdf(): StreamedResponse
    {
        $data = $this->getTransaksiQuery()->get();

        if ($data->isEmpty()) {
            abort(404, 'Data tidak ditemukan');
        }

        $periode = PeriodeBanjar::find(
            $this->periode_banjar_id
        );

        $pdf = Pdf::loadView(
            'filament.pages.laporan-banjar-pdf',
            [
                'judulLaporan' => $this->getJudulLaporan(),
                'periode' => $periode,
                'data' => $data,
                'totalKasAwal' => $this->totalKasAwal,
                'totalPemasukan' => $this->totalPemasukan,
                'totalPengeluaran' => $this->totalPengeluaran,
                'saldo' => $this->saldo,
            ]
        )->setPaper('a4', 'portrait');

        return response()->streamDownload(
            fn () => print($pdf->output()),
            'laporan-banjar.pdf'
        );
    }

    public function getTotalKasAwalProperty(): float
    {
        return (float) $this->getTransaksiQuery()
            ->where('tipe', 'kas-awal')
            ->sum('nominal');
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
        return $this->totalKasAwal
            + $this->totalPemasukan
            - $this->totalPengeluaran;
    }
    public function getSaldoKategori(int $kategoriId): float
    {
        $query = $this->getTransaksiQuery()
            ->where('kategori_dana_banjar_id', $kategoriId);

        return
            (clone $query)
                ->whereIn('tipe', ['kas-awal', 'pemasukan'])
                ->sum('nominal')
            -
            (clone $query)
                ->where('tipe', 'pengeluaran')
                ->sum('nominal');
    }
    public function getSaldoDepositoProperty(): float
    {
        return $this->getSaldoKategori(1);
    }

    public function getSaldoTabunganProperty(): float
    {
        return $this->getSaldoKategori(2);
    }

    public function getSaldoDanaCashProperty(): float
    {
        return $this->getSaldoKategori(7);
    }

    public function getSaldoKasPrajuruProperty(): float
    {
        return $this->getSaldoKategori(8);
    }
    
    public function getTotalSaldoSemuaProperty(): float
    {
        return
            $this->saldoDeposito +
            $this->saldoTabungan +
            $this->saldoDanaCash +
            $this->saldoKasPrajuru;
    }
    protected function getTransaksiQuery()
    {
        return TransaksiBanjar::query()
            ->with([
                'kategoriDanaBanjar',
                'periode',
            ])
            ->where(
                'periode_banjar_id',
                $this->periode_banjar_id
            )
            ->whereIn(
                'kategori_dana_banjar_id',
                $this->getKategoriIds()
            )
            ->orderBy('tanggal', 'asc');
    }
}
