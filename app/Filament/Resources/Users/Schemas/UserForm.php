<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi User')
                    ->description('Kelola data akun pengguna PenaKas.')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama')
                            ->placeholder('Contoh: Administrator')
                            ->required()
                            ->maxLength(255)
                            ->autofocus(),

                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->placeholder('admin@penakas.local')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->revealable()
                            ->dehydrated(fn ($state) => filled($state))
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->maxLength(255)
                            ->helperText('Kosongkan jika tidak ingin mengubah password.'),

                        Select::make('roles')
                            ->label('Role')
                            ->relationship('roles', 'name')
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->required()
                            ->helperText('Pilih role sesuai akses user.'),
                    ])
                    ->columns([
                        'default' => 1,
                        'md' => 2,
                    ])
                    ->columnSpanFull(),
            ]);
    }
}