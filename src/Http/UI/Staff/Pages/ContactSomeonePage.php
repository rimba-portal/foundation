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
use Illuminate\Support\HtmlString;
use UnitEnum;

class ContactSomeonePage extends Page implements HasSchemas
{
    use InteractsWithSchemas;

    protected static string|UnitEnum|null $navigationGroup = 'Escalation';

    protected static string|BackedEnum|null $navigationIcon = 'bites-s-phone-call';

    protected static ?string $navigationLabel = 'Contact Someone';

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

        $items = $fullData['sensitive'] ?? [];
        $sections = [];

        foreach ($items as $index => $item) {
            $levelSections = [];

            foreach ($item['escalation'] ?? [] as $escIndex => $escalation) {
                $levelNumber = $escIndex + 1;
                $channelEntries = [];

                // 1. Social Media Channel
                if (! empty($escalation['smp'])) {
                    $qrvalue = $escalation['smp']['cto'] ?? '#';
                    $channelEntries[] = TextEntry::make("esc_wa_{$index}_{$escIndex}")
                        ->hiddenLabel()
                        ->getStateUsing(fn (): mixed => $escalation['smp']['label'] ?? 'Social Media Platform')
                        ->prefixAction(
                            Action::make('link_to_social_media')
                                ->icon('heroicon-m-chat-bubble-left-right')
                                ->url($qrvalue)
                                ->openUrlInNewTab()
                        )
                        ->suffixAction(
                            Action::make('Qrcode_to_social_media')
                                ->icon('heroicon-m-qr-code')
                                // ->extraAttributes([
                                //     'x-on:click.stop' => 'true',
                                //     'style' => 'pointer-events: auto;'
                                // ])
                                ->modalHeading('Scan QR Code')
                                ->modalWidth('sm')
                                ->modalSubmitAction(false)
                                ->modalCancelActionLabel('Close')
                                ->modalContent(function () use ($qrvalue): HtmlString {
                                    // Safely grab the URL value from your loop context

                                    return new HtmlString('
                    <div class="flex flex-col items-center justify-center p-6 text-center">
                        <div class="p-3 bg-white rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                            <img 
                                src="https://quickchart.io/qr?text='.urlencode($qrvalue).'&size=350" 
                                alt="QR code to scan" 
                                class="w-64 h-64 object-contain mx-auto"
                            />
                        </div>
                        <p class="mt-4 text-sm text-gray-500 dark:text-gray-400 break-all max-w-xs">
                            '.e($qrvalue).'
                        </p>
                    </div>
                ');
                                })
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
                        ->suffixAction(
                            Action::make('Qrcode_to_social_media')
                                ->icon('heroicon-m-qr-code')
                                // ->extraAttributes([
                                //     'x-on:click.stop' => 'true',
                                //     'style' => 'pointer-events: auto;'
                                // ])
                                ->modalHeading('Scan QR Code')
                                ->modalWidth('sm')
                                ->modalSubmitAction(false)
                                ->modalCancelActionLabel('Close')
                                ->modalContent(function () use ($qrvalue): HtmlString {
                                    // Safely grab the URL value from your loop context

                                    return new HtmlString('
                    <div class="flex flex-col items-center justify-center p-6 text-center">
                        <div class="p-3 bg-white rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                            <img 
                                src="https://quickchart.io/qr?text='.urlencode($qrvalue).'&size=350" 
                                alt="QR code to scan" 
                                class="w-64 h-64 object-contain mx-auto"
                            />
                        </div>
                        <p class="mt-4 text-sm text-gray-500 dark:text-gray-400 break-all max-w-xs">
                            '.e($qrvalue).'
                        </p>
                    </div>
                ');
                                })
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
                        ->getStateUsing(fn (): string => '');
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
                // ->aside()
                ->schema([
                    Grid::make(3)->schema($levelSections),
                ]);
        }

        return $schema
            ->state($fullData)
            ->schema($sections);
    }
}
