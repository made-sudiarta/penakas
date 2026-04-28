<?php

namespace App\Filament\Pages\Auth;

use App\Models\AppSetting;
use Filament\Auth\Pages\Login as BaseLogin;

class Login extends BaseLogin
{
    protected string $view = 'filament.pages.auth.login';

    public function getTitle(): string
    {
        return 'Sign in - ' . (AppSetting::getSetting()->app_name);
    }

    public function getHeading(): string
    {
        return 'Masuk ke Akun';
    }

    public function getSubheading(): ?string
    {
        return (AppSetting::getSetting()->description ?? 'Kelola kas rumah kos dan banjar dengan mudah.');
    }
}