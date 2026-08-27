<?php

declare(strict_types=1);

namespace Rimba\Foundation\Actions;

use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Rimba\Who\Contracts\PanelAccessResolverContract;

class DiscoverCanAccessPanels
{
    protected array $panels = ['lobby', 'staff', 'team', 'admin'];

    protected array $labels = [
        'lobby' => 'Lobby',
        'staff' => 'Staff',
        'team' => 'Team',
        'admin' => 'Admin',
    ];

    public function register(): void
    {
        FilamentView::registerRenderHook(
            PanelsRenderHook::GLOBAL_SEARCH_BEFORE,
            fn (): string => $this->execute()
        );
    }

    public function execute(): string
    {
        $user = auth()->user();

        if (! $user) {
            return '';
        }

        $panelAccessResolverContract = app(PanelAccessResolverContract::class);
        $currentPanel = Filament::getCurrentPanel()?->getId();

        return collect($this->panels)
            ->filter(fn (string $panelId) => $panelAccessResolverContract->canAccess($user, $panelId))
            ->map(function (string $panelId) use ($currentPanel): ?\Filament\Actions\Action {
                $panelInstance = Filament::getPanel($panelId);
                $url = $panelInstance?->getUrl();

                if (! $url) {
                    return null;
                }

                return Action::make($panelId)
                    ->label($this->labels[$panelId] ?? ucfirst($panelId))
                    ->iconButton()
                    ->color($currentPanel === $panelId ? 'primary' : 'gray')
                    ->icon("bites-p-{$panelId}")
                    ->url($url);
            })
            ->filter()
            ->map->toHtml()
            ->implode('');
    }

    public function __invoke(): string
    {
        return $this->execute();
    }
}
