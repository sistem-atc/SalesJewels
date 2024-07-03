<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Navigation\MenuItem;
use Filament\Support\Colors\Color;
use App\Filament\Pages\Auth\EditProfile;
use App\Filament\Resources\BillResource;
use App\Models\Bill;
use Rupadana\ApiService\ApiServicePlugin;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('PSJ')
            ->path('psj')
            ->sidebarCollapsibleOnDesktop()
            ->login()
            ->topNavigation()
            ->registration()
            ->userMenuItems($this->MenuItens())
            ->passwordReset()
            ->emailVerification()
            ->profile(EditProfile::class)
            ->brandName('PSJ Semi-Joias')
            ->brandLogo(asset('w-Logo.png'))
            ->darkModeBrandLogo(asset('b-Logo.png'))
            ->brandLogoHeight('4rem')
            ->colors($this->useColors())
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages($this->usePages())
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([])
            ->middleware($this->useMiddleware())
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugins($this->usePlugins());
    }

    private function MenuItens(): array
    {
        return [
            'configurações' =>
                MenuItem::make()->label('Configurações')
                    ->url(fn (): string => BillResource::getUrl())
                    ->icon('heroicon-o-cog-8-tooth'),
            'administração' =>
                MenuItem::make()->label('Administração')
                    ->icon('heroicon-o-adjustments-vertical'),
            'logout' =>
                MenuItem::make()->label('Sair'),
        ];
    }

    private function usePlugins(): array
    {
        return [
            ApiServicePlugin::make(),
            FilamentShieldPlugin::make()
        ];
    }

    private function useColors(): array
    {
        return [
            'primary' => Color::Violet,
            'Red' => Color::Red,
        ];
    }

    private function useMiddleware(): array
    {
        return [
            EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
            StartSession::class,
            AuthenticateSession::class,
            ShareErrorsFromSession::class,
            VerifyCsrfToken::class,
            SubstituteBindings::class,
            DisableBladeIconComponents::class,
            DispatchServingFilamentEvent::class,
        ];
    }

    private function usePages(): array
    {
        return [
            Pages\Dashboard::class,
        ];
    }
}
