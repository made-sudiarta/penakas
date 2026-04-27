<?php

namespace App\Filament\Pages;

use App\Models\AppSetting;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ProfilAplikasi extends Page implements HasSchemas
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string|UnitEnum|null $navigationGroup = 'Pengaturan';

    protected static ?string $navigationLabel = 'Profil Aplikasi';

    protected static ?string $title = 'Profil Aplikasi';

    protected static ?int $navigationSort = 2;

    protected string $view = 'filament.pages.profil-aplikasi';

    public ?array $data = [];

    public function mount(): void
    {
        $setting = AppSetting::getSetting();

        $this->form->fill([
            'app_name' => $setting->app_name,
            'owner_name' => $setting->owner_name,
            'phone' => $setting->phone,
            'address' => $setting->address,
            'logo' => $setting->logo,
        ]);
    }

    public function getMaxContentWidth(): Width|string|null
    {
        return Width::Full;
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Section::make('Identitas Aplikasi')
                    ->description('Atur informasi utama aplikasi PenaKas.')
                    ->schema([
                        TextInput::make('app_name')
                            ->label('Nama Aplikasi')
                            ->required()
                            ->maxLength(255)
                            ->default('PenaKas'),

                        TextInput::make('owner_name')
                            ->label('Nama Pemilik / Pengelola')
                            ->placeholder('Contoh: Made Sudiarta')
                            ->maxLength(255),

                        TextInput::make('phone')
                            ->label('No. HP')
                            ->placeholder('Contoh: 081234567890')
                            ->tel()
                            ->maxLength(255),

                        FileUpload::make('logo')
                            ->label('Logo')
                            ->image()
                            ->disk('public')
                            ->directory('app-logo')
                            ->visibility('public')
                            ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/webp'])
                            ->maxSize(2048)
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('1:1')
                            ->imageResizeTargetWidth('512')
                            ->imageResizeTargetHeight('512')
                            ->imageEditor()
                            ->downloadable()
                            ->openable()
                            ->multiple(false)
                            ->dehydrated(true)
                            ->columnSpanFull(),

                        Textarea::make('address')
                            ->label('Alamat')
                            ->placeholder('Alamat lengkap')
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

    

    public function save(): void
    {
        $data = $this->form->getState();

        if (is_array($data['logo'] ?? null)) {
            $data['logo'] = collect($data['logo'])->first();
        }

        AppSetting::getSetting()->update($data);

        Notification::make()
            ->title('Profil aplikasi berhasil disimpan')
            ->success()
            ->send();
    }
}