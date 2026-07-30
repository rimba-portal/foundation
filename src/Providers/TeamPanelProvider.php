<?php

declare(strict_types=1);

namespace Rimba\Foundation\Providers;

use Filament\Actions\Action;
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
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings; // Import the Action class
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Rimba\Who\Http\UI\Auth\LoginWizard;

class TeamPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        // dd(config('bites'));
        $panel
            ->default()
            ->login(LoginWizard::class)
            ->id(config('bites.ui.panels.team.0', 'team'))
            ->path(config('bites.ui.panels.team.1', 'team'))
            ->colors(['primary' => config('bites.ui.panels.team.2', Color::Green)])
            ->brandName(config('bites.ui.panels.team.3', 'Team'))
            ->homeUrl(fn (): string => route(config('bites.ui.panels.team.4', 'filament.team.pages.dashboard')))

            // Discover for UI
            ->discoverResources(in: app_path('Http/UI/Team/Resources'), for: 'App\\Http\\UI\\Team\\Resources')
            ->discoverPages(in: app_path('Http/UI/Team/Pages'), for: 'App\Http\UI\Team\Pages')
            ->discoverWidgets(in: app_path('Http/UI/Team/Widgets'), for: 'App\Http\UI\Team\Widgets');

        $packages = Cache::get('rimba_packages', []);

        foreach ($packages as $package => $namespace) {
            $panel
                ->discoverResources(
                    in: base_path(sprintf('vendor/rimba/%s/Http/UI/Team/Resources', $package)),
                    for: 'Rimba\\'.$namespace.'\\Http\\UI\\Team\\Resources',
                )
                ->discoverPages(
                    in: base_path(sprintf('vendor/rimba/%s/Http/UI/Team/Pages', $package)),
                    for: 'Rimba\\'.$namespace.'\\Http\\UI\\Team\\Pages',
                )
                ->discoverWidgets(
                    in: base_path(sprintf('vendor/rimba/%s/Http/UI/Team/Widgets', $package)),
                    for: 'Rimba\\'.$namespace.'\\Http\\UI\\Team\\Widgets',
                );
        }

        return $panel
            ->navigationGroups([
                'Profile',
                'Onboarding',
                'Policy',
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
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
