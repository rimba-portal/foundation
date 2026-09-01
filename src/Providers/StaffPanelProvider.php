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
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings; // Import the Action class
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Rimba\Who\Http\Middleware\EnsureFaceVerification;
use Rimba\Who\Http\Middleware\EnsurePanelAccess;
use Rimba\Who\Http\UI\Auth\Login;
use Rimba\Who\Http\UI\Auth\Register;
use Rimba\Who\Http\UI\Auth\RequestPasswordReset;
use Rimba\Who\Http\UI\Auth\ResetPassword;

class StaffPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $panel
            ->default()
            ->login(Login::class)
            ->registration(Register::class)
            ->passwordReset(
                requestAction: RequestPasswordReset::class,
                resetAction: ResetPassword::class,
            )
            ->id(config('bites.ui.panels.staff.0', 'staff'))
            ->path(config('bites.ui.panels.staff.1', 'staff'))
            ->colors(['primary' => config('bites.ui.panels.staff.2', Color::Cyan)])
            ->brandName(config('bites.ui.panels.staff.3', 'Staff Portal'))
            ->homeUrl(fn (): string => route(config('bites.ui.panels.staff.4', 'filament.staff.pages.dashboard')))

            // Discover for UI
            ->discoverResources(in: app_path('Http/UI/Staff/Resources'), for: 'App\\Http\\UI\\Staff\\Resources')
            ->discoverPages(in: app_path('Http/UI/Staff/Pages'), for: 'App\\Http\\UI\\Staff\\Pages')
            ->discoverWidgets(in: app_path('Http/UI/Staff/Widgets'), for: 'App\\Http\\UI\\Staff\\Widgets');

        $packages = Cache::get('rimba_packages', []);

        foreach ($packages as $package => $namespace) {
            $panel
                ->discoverResources(
                    in: base_path(sprintf('vendor/rimba/%s/src/Http/UI/Staff/Resources', $package)),
                    for: 'Rimba\\'.$namespace.'\\Http\\UI\\Staff\\Resources',
                )
                ->discoverPages(
                    in: base_path(sprintf('vendor/rimba/%s/src/Http/UI/Staff/Pages', $package)),
                    for: 'Rimba\\'.$namespace.'\\Http\\UI\\Staff\\Pages',
                );
            // ->discoverWidgets(
            //     in: base_path(sprintf('vendor/rimba/%s/src/Http/UI/Staff/Widgets', $package)),
            //     for: 'Rimba\\'.$namespace.'\\Http\\UI\\Staff\\Widgets',
            // );
        }

        return $panel
            ->navigationGroups([
                'ToDo',
                'Accountables',
                'Catalog',
                'Knowledge',
                'Learning',
                'Emergency',
                'Resources',
                'Systems',
            ])
            ->pages([
                // Dashboard::class,
            ])
            ->widgets([])
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
                EnsurePanelAccess::class.':staff',
            ]);
    }
}
