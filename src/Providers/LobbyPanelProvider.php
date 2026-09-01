<?php

declare(strict_types=1);

namespace Rimba\Foundation\Providers;

use Filament\Actions\Action;
use Filament\Auth\MultiFactor\App\AppAuthentication;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery; // Import the Action class
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Rimba\Who\Http\Middleware\EnsureFaceVerification;
use Rimba\Who\Http\Middleware\EnsurePanelAccess;
use Rimba\Who\Http\UI\Auth\Login;
use Rimba\Who\Http\UI\Auth\Register;
use Rimba\Who\Http\UI\Auth\RequestPasswordReset;
use Rimba\Who\Http\UI\Auth\ResetPassword;

class LobbyPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        // dd(config('bites'));
        $panel
            ->default()
            ->login(Login::class)
            ->registration(Register::class)
            ->passwordReset(
                requestAction: RequestPasswordReset::class,
                resetAction: ResetPassword::class,
            )
            ->multiFactorAuthentication([
                AppAuthentication::make(),
            ])
            ->id(config('bites.ui.panels.lobby.0', 'lobby'))
            ->path(config('bites.ui.panels.lobby.1', 'lobby'))
            ->colors(['primary' => config('bites.ui.panels.lobby.2', Color::Blue)])
            ->brandName(config('bites.ui.panels.lobby.3', 'Lobby'))
            ->homeUrl(fn (): string => route(config('bites.ui.panels.lobby.4', 'filament.lobby.pages.dashboard')))
            // Discover for UI
            ->discoverResources(in: app_path('Http/UI/Lobby/Resources'), for: 'App\\Http\\UI\\Lobby\\Resources')
            ->discoverPages(in: app_path('Http/UI/Lobby/Pages'), for: 'App\Http\UI\Lobby\Pages')
            ->discoverWidgets(in: app_path('Http/UI/Lobby/Widgets'), for: 'App\Http\UI\Lobby\Widgets');

        $packages = Cache::get('rimba_packages', []);

        foreach ($packages as $package => $namespace) {
            $panel
                ->discoverResources(
                    in: base_path(sprintf('vendor/rimba/%s/Http/UI/Lobby/Resources', $package)),
                    for: 'Rimba\\'.$namespace.'\\Http\\UI\\Lobby\\Resources',
                )
                ->discoverPages(
                    in: base_path(sprintf('vendor/rimba/%s/Http/UI/Lobby/Pages', $package)),
                    for: 'Rimba\\'.$namespace.'\\Http\\UI\\Lobby\\Pages',
                );
        }

        return $panel
            ->navigationGroups([
                'Profile',
                'Induction',
                'Policy',
                'Emergency',
            ])
            ->pages([
                Dashboard::class,
            ])
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                EnsureFaceVerification::class,
            ])
            ->authMiddleware([
                Authenticate::class,
                EnsurePanelAccess::class.':lobby',
            ]);
    }
}
