<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\PeriodeBanjar;
use App\Models\TransaksiBanjar;


class LaporanPerAkunBanjar extends Page
{
    protected string $view = 'filament.pages.laporan-per-akun-banjar';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-chart-bar';

    protected static string|\UnitEnum|null $navigationGroup = 'Laporan';

    protected static ?string $navigationLabel = 'Laporan Per Akun Banjar';

    protected static ?string $title = '';

    protected static ?int $navigationSort = 3;

    public ?int $periode_banjar_id = null;

    public string $jenis_laporan = 'banjar';

    public function mount(): void
    {
        $this->periode_banjar_id = PeriodeBanjar::query()
            ->where('is_active', true)
            ->value('id');
    }

    public function getLaporanProperty()
    {
        $query = TransaksiBanjar::query()
            ->selectRaw('
                akun_keuangan_banjar_id,
                SUM(nominal) as total
            ')
            ->with('akun')
            ->where('periode_banjar_id', $this->periode_banjar_id);

        if ($this->jenis_laporan === 'banjar') {

            $query->whereIn('kategori_dana_banjar_id', [
                1, // Deposito LPD
                2, // Tabungan LPD
                7, // Dana Cash
            ]);

        } elseif ($this->jenis_laporan === 'prajuru') {

            $query->where('kategori_dana_banjar_id', 8);

        }

        return $query
            ->groupBy('akun_keuangan_banjar_id')
            ->orderBy('akun_keuangan_banjar_id')
            ->get();
    }

    public function getSaldoKategori(int $kategoriId): float
    {
        $query = TransaksiBanjar::query()
            ->where('periode_banjar_id', $this->periode_banjar_id)
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
    public function getAsetProperty()
    {
        return collect([
            (object) [
                'kode' => '1101',
                'nama' => 'Dana Cash',
                'total' => $this->getSaldoKategori(7),
            ],

            (object) [
                'kode' => '1102',
                'nama' => 'Tabungan LPD',
                'total' => $this->getSaldoKategori(2),
            ],

            (object) [
                'kode' => '1103',
                'nama' => 'Deposito LPD',
                'total' => $this->getSaldoKategori(1),
            ],

            (object) [
                'kode' => '1104',
                'nama' => 'Kas Prajuru',
                'total' => $this->getSaldoKategori(8),
            ],
        ])->filter(function ($item) {

            if ($this->jenis_laporan === 'banjar') {
                return in_array($item->kode, [
                    '1101',
                    '1102',
                    '1103',
                ]);
            }

            if ($this->jenis_laporan === 'prajuru') {
                return $item->kode === '1104';
            }

            return true;
        });
    }

    public function getPendapatanProperty()
    {
        return $this->laporan
            ->filter(fn ($item) =>
                $item->akun?->tipe === 'pendapatan'
            );
    }

    public function getBebanProperty()
    {
        return $this->laporan
            ->filter(fn ($item) =>
                $item->akun?->tipe === 'beban'
            );
    }

    public function getTotalAsetProperty()
    {
        return $this->aset->sum('total');
    }

    public function getTotalPendapatanProperty()
    {
        return $this->pendapatan->sum('total');
    }

    public function getTotalBebanProperty()
    {
        return $this->beban->sum('total');
    }
    public function getSurplusDefisitProperty(): float
    {
        return $this->totalPendapatan - $this->totalBeban;
    }

    public function getJudulProperty(): string
    {
        return match ($this->jenis_laporan) {
            'banjar' => 'Laporan Keuangan Banjar',
            'prajuru' => 'Laporan Keuangan Prajuru',
            default => 'Laporan Keuangan Gabungan',
        };
    }
}
