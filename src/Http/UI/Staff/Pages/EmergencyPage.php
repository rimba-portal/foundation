<?php

declare(strict_types=1);

namespace Rimba\Foundation\Http\UI\Staff\Pages;

use BackedEnum;
use Filament\Actions\Action;
use Filament\Infolists\Components\TextEntry;
use Filament\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Filament\Support\Enums\TextSize;
use UnitEnum;

class EmergencyPage extends Page implements HasSchemas
{
    use InteractsWithSchemas;

    protected static string|UnitEnum|null $navigationGroup = 'Escalation';

    protected static string|BackedEnum|null $navigationIcon = 'bites-s-urgent';

    protected static ?string $navigationLabel = 'Emergency';

    protected static ?int $navigationSort = 62;

    protected static ?string $title = 'Emergency Response Level Matrix';

    protected string $view = 'bites::pages.call';

    public function contactInfolist(Schema $schema): Schema
    {
        $filePath = storage_path('app/private/escalation.json');

        $fullData = [];
        if (file_exists($filePath)) {
            $jsonContent = file_get_contents($filePath);
            $fullData = json_decode($jsonContent, true) ?? [];
        }

        $items = $fullData['emergency'] ?? [];
        $sections = [];

        foreach ($items as $index => $item) {
            $levelSections = [];

            foreach ($item['escalation'] ?? [] as $escIndex => $escalation) {
                $levelNumber = $escIndex + 1;
                $channelEntries = [];

                // 1. Social Media Channel
                if (! empty($escalation['smp'])) {
                    $channelEntries[] = TextEntry::make("esc_wa_{$index}_{$escIndex}")
                        ->hiddenLabel()
                        ->getStateUsing(fn (): mixed => $escalation['smp']['label'] ?? 'Social Media Platform')
                        ->url($escalation['smp']['cto'] ?? '#')
                        ->openUrlInNewTab()
                        ->prefixAction(
                            Action::make('smp_prefix')
                                ->icon('heroicon-m-chat-bubble-left-right')
                        )->suffixAction(
                            Action::make('smp_suffix')
                                ->icon('heroicon-m-qr-code')
                        )
                        ->color('success')
                        ->weight('medium');
                }

                // 2. Email Channel
                if (! empty($escalation['email'])) {
                    $channelEntries[] = TextEntry::make("esc_email_{$index}_{$escIndex}")
                        ->hiddenLabel()
                        ->getStateUsing(fn (): mixed => $escalation['email']['label'] ?? 'Email')
                        ->url($escalation['email']['cto'] ?? '#')
                        ->prefixAction(
                            Action::make('email_prefix')
                                ->icon('heroicon-m-envelope')
                        )
                        ->color('primary')
                        ->weight('medium');
                }

                // 3. Map / Location Pin Channel
                if (! empty($escalation['map'])) {
                    $channelEntries[] = TextEntry::make("esc_map_{$index}_{$escIndex}")
                        ->hiddenLabel()
                        ->getStateUsing(fn (): mixed => $escalation['map']['label'] ?? '')
                        ->url($escalation['map']['cto'] ?? '#')
                        ->openUrlInNewTab()
                        ->prefixAction(
                            Action::make('map_prefix')
                                ->icon('heroicon-m-map-pin')
                        )
                        ->color('info')
                        ->size(TextSize::ExtraSmall);
                }

                // 4. Call / Phone Channel
                if (! empty($escalation['call'])) {
                    $channelEntries[] = TextEntry::make("esc_call_{$index}_{$escIndex}")
                        ->hiddenLabel()
                        ->getStateUsing(fn (): mixed => $escalation['call']['label'] ?? '')
                        ->url($escalation['call']['cto'] ?? '#')
                        ->prefixAction(
                            Action::make('call_prefix')
                                ->icon('heroicon-m-phone')
                        )
                        ->color('warning')
                        ->weight('medium');
                }

                // If no specific channels found, display the escalation name as plain text
                if ($channelEntries === []) {
                    $channelEntries[] = TextEntry::make("esc_fallback_{$index}_{$escIndex}")
                        ->hiddenLabel()
                        ->getStateUsing(fn (): string => 'No communication channels configured.');
                }

                // Wrap all active channel links neatly inside a Level card section
                $levelSections[] = Section::make("Level {$levelNumber}: ".($escalation['name'] ?? 'Contact'))
                    ->compact()
                    ->secondary()
                    ->schema($channelEntries);
            }

            $sections[] = Section::make($item['title'] ?? 'Incident Response')
                ->description($item['description'] ?? '')
                ->icon($item['icon'] ?? 'bites-e-alarm')
                ->aside()
                ->schema([
                    Grid::make(2)->schema($levelSections),
                ]);
        }

        return $schema
            ->state($fullData)
            ->schema($sections);
    }
}
