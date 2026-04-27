<?php

namespace App\Filament\Resources\TransaksiBanjars\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class TransaksiBanjarForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Transaksi')
                    ->description('Catat pemasukan atau pengeluaran berdasarkan kategori dana.')
                    ->schema([
                        Select::make('kategori_dana_banjar_id')
                            ->label('Kategori Dana')
                            ->relationship(
                                name: 'kategoriDanaBanjar',
                                titleAttribute: 'nama',
                                modifyQueryUsing: fn ($query) => $query->where('is_active', true),
                            )
                            ->searchable()
                            ->preload()
                            ->required(),

                        Select::make('tipe')
                            ->label('Tipe Transaksi')
                            ->options([
                                'pemasukan' => 'Pemasukan',
                                'pengeluaran' => 'Pengeluaran',
                            ])
                            ->native(false)
                            ->default('pemasukan')
                            ->required(),

                        DatePicker::make('tanggal')
                            ->label('Tanggal')
                            ->native(false)
                            ->displayFormat('d M Y')
                            ->default(now())
                            ->required(),

                        TextInput::make('judul')
                            ->label('Judul Transaksi')
                            ->placeholder('Contoh: Iuran warga / Beli konsumsi')
                            ->required()
                            ->maxLength(255)
                            ->autofocus(),

                        TextInput::make('nominal')
                            ->label('Nominal')
                            ->numeric()
                            ->prefix('Rp')
                            ->placeholder('100000')
                            ->default(0)
                            ->minValue(0)
                            ->required(),

                        Hidden::make('created_by')
                            ->default(fn () => Auth::id()),

                        FileUpload::make('foto_nota')
                            ->label('Foto Nota / Kuitansi')
                            ->image()
                            ->directory('nota-banjar')
                            ->visibility('public')
                            ->imageEditor()
                            ->downloadable()
                            ->openable()
                            ->columnSpanFull(),

                        Textarea::make('keterangan')
                            ->label('Keterangan')
                            ->placeholder('Catatan tambahan transaksi')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                        'xl' => 3,
                    ])
                    ->columnSpanFull(),
            ]);
    }
}