<?php

namespace App\Filament\Pages\Auth;

use App\Models\AppSetting;
use Filament\Auth\Pages\Login as BaseLogin;

class Login extends BaseLogin
{
    protected string $view = 'filament.pages.auth.login';

    public function getTitle(): string
    {
        return 'Login - ' . (AppSetting::getSetting()->app_name ?? 'PenaKas');
    }

    public function getHeading(): string
    {
        return 'Masuk ke Akun';
    }

    public function getSubheading(): ?string
    {
        return 'Kelola kas rumah kos dan banjar dengan mudah.';
    }
}