<?php

namespace App\Filament\Resources\PembayaranKosts\Schemas;

use App\Models\TagihanKost;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PembayaranKostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Pembayaran')
                    ->description('Pilih tagihan yang dibayar dan isi nominal pembayaran.')
                    ->schema([
                        Select::make('tagihan_kost_id')
                            ->label('Tagihan Kost')
                            ->options(function ($record): array {
                                return TagihanKost::query()
                                    ->with(['penghuni', 'kamarKost'])
                                    ->when(
                                        $record,
                                        fn ($query) => $query->where(function ($query) use ($record) {
                                            $query
                                                ->whereIn('status', ['belum_lunas', 'sebagian'])
                                                ->orWhere('id', $record->tagihan_kost_id);
                                        }),
                                        fn ($query) => $query->whereIn('status', ['belum_lunas', 'sebagian'])
                                    )
                                    ->orderByDesc('tahun')
                                    ->orderByDesc('bulan')
                                    ->get()
                                    ->mapWithKeys(function (TagihanKost $tagihan) {
                                        $bulan = [
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

                                        $periode = ($bulan[$tagihan->bulan] ?? $tagihan->bulan) . ' ' . $tagihan->tahun;
                                        $namaPenghuni = $tagihan->penghuni?->nama ?? '-';
                                        $namaKamar = $tagihan->kamarKost?->nama_kamar ?? '-';
                                        $sisa = max(0, $tagihan->total_tagihan - $tagihan->total_dibayar);

                                        return [
                                            $tagihan->id => "{$namaPenghuni} - {$namaKamar} - {$periode} - Sisa Rp " . number_format($sisa, 0, ',', '.'),
                                        ];
                                    })
                                    ->toArray();
                            })
                            ->searchable()
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $tagihan = TagihanKost::query()->find($state);

                                if (! $tagihan) {
                                    return;
                                }

                                $sisa = max(0, $tagihan->total_tagihan - $tagihan->total_dibayar);

                                $set('jumlah_bayar', $sisa);
                            }),

                        DatePicker::make('tanggal_bayar')
                            ->label('Tanggal Bayar')
                            ->native(false)
                            ->displayFormat('d M Y')
                            ->default(now())
                            ->required(),

                        TextInput::make('jumlah_bayar')
                            ->label('Jumlah Bayar')
                            ->numeric()
                            ->prefix('Rp')
                            ->default(0)
                            ->minValue(1)
                            ->required(),

                        Select::make('metode_pembayaran')
                            ->label('Metode Pembayaran')
                            ->options([
                                'cash' => 'Cash',
                                'transfer' => 'Transfer',
                                'qris' => 'QRIS',
                                'lainnya' => 'Lainnya',
                            ])
                            ->native(false)
                            ->default('cash')
                            ->required(),

                        FileUpload::make('bukti_pembayaran')
                            ->label('Bukti Pembayaran')
                            ->image()
                            ->directory('bukti-pembayaran-kost')
                            ->visibility('public')
                            ->imageEditor()
                            ->downloadable()
                            ->openable()
                            ->columnSpanFull(),

                        Textarea::make('catatan')
                            ->label('Catatan')
                            ->placeholder('Catatan tambahan pembayaran')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                        'xl' => 4,
                    ])
                    ->columnSpanFull(),
            ]);
    }
}