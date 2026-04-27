<?php

namespace App\Filament\Resources\TagihanKosts\Schemas;

use App\Models\JenisTagihanKost;
use App\Models\Penghuni;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TagihanKostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Tagihan')
                    ->description('Pilih penghuni, periode tagihan, dan tanggal jatuh tempo.')
                    ->schema([
                        Select::make('penghuni_id')
                            ->label('Penghuni')
                            ->relationship('penghuni', 'nama')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $penghuni = Penghuni::query()->find($state);

                                $set('kamar_kost_id', $penghuni?->kamar_kost_id);
                            }),

                        Hidden::make('kamar_kost_id'),

                        Select::make('bulan')
                            ->label('Bulan')
                            ->options([
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
                            ])
                            ->native(false)
                            ->default((int) now()->format('n'))
                            ->required(),

                        TextInput::make('tahun')
                            ->label('Tahun')
                            ->numeric()
                            ->default((int) now()->format('Y'))
                            ->required()
                            ->minValue(2000)
                            ->maxValue(2100),

                        DatePicker::make('tanggal_jatuh_tempo')
                            ->label('Tanggal Jatuh Tempo')
                            ->native(false)
                            ->displayFormat('d M Y'),

                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'belum_lunas' => 'Belum Lunas',
                                'sebagian' => 'Sebagian',
                                'lunas' => 'Lunas',
                                'dibatalkan' => 'Dibatalkan',
                            ])
                            ->native(false)
                            ->default('belum_lunas')
                            ->required(),
                    ])
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                        'xl' => 4,
                    ])
                    ->columnSpanFull(),

                Section::make('Detail Tagihan')
                    ->description('Tambahkan komponen tagihan seperti harga kamar, air, listrik, internet, dan lainnya.')
                    ->schema([
                        Repeater::make('details')
                            ->label('Item Tagihan')
                            ->relationship('details')
                            ->schema([
                                Select::make('jenis_tagihan_kost_id')
                                    ->label('Jenis Tagihan')
                                    ->relationship('jenisTagihanKost', 'nama')
                                    ->searchable()
                                    ->preload()
                                    ->live()
                                    ->required()
                                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                        $jenisTagihan = JenisTagihanKost::query()->find($state);

                                        if (! $jenisTagihan) {
                                            return;
                                        }

                                        $set('nama_tagihan', $jenisTagihan->nama);
                                        $set('nominal', $jenisTagihan->nominal_default);

                                        self::hitungTotalTagihan($get, $set);
                                    }),

                                TextInput::make('nama_tagihan')
                                    ->label('Nama Tagihan')
                                    ->required()
                                    ->maxLength(255),

                                TextInput::make('nominal')
                                    ->label('Nominal')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->default(0)
                                    ->minValue(0)
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                        self::hitungTotalTagihan($get, $set);
                                    }),
                            ])
                            ->columns([
                                'default' => 1,
                                'md' => 3,
                            ])
                            ->defaultItems(1)
                            ->addActionLabel('Tambah Item Tagihan')
                            ->reorderable(false)
                            ->collapsible()
                            ->live()
                            ->afterStateUpdated(function (callable $get, callable $set) {
                                self::hitungTotalTagihan($get, $set);
                            })
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),

                Section::make('Total & Catatan')
                    ->description('Total tagihan dihitung dari seluruh detail item.')
                    ->schema([
                        TextInput::make('total_tagihan')
                            ->label('Total Tagihan')
                            ->numeric()
                            ->prefix('Rp')
                            ->default(0)
                            ->minValue(0)
                            ->required()
                            ->readOnly()
                            ->dehydrated(true),

                        TextInput::make('total_dibayar')
                            ->label('Total Dibayar')
                            ->numeric()
                            ->prefix('Rp')
                            ->default(0)
                            ->minValue(0)
                            ->disabled()
                            ->dehydrated(true)
                            ->helperText('Akan otomatis terisi dari data pembayaran.'),

                        Textarea::make('catatan')
                            ->label('Catatan')
                            ->placeholder('Catatan tambahan untuk tagihan ini')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ])
                    ->columnSpanFull(),
            ]);
    }

    protected static function hitungTotalTagihan(callable $get, callable $set): void
    {
        $details = $get('details') ?? [];

        $total = collect($details)
            ->sum(function ($item) {
                return (float) ($item['nominal'] ?? 0);
            });

        $set('total_tagihan', $total);
    }
}