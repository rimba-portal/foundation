<?php

declare(strict_types=1);

namespace Rimba\Foundation\Http\UI\Staff\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;

class EscalationSchemaBuilder
{
    public function __construct(
        protected EscalationChannelFactory $factory
    ) {}

    public function build(
        array $items,
        int $columns = 2
    ): array {

        $sections = [];

        foreach ($items as $index => $item) {

            $levelSections = [];

            foreach (
                $item['escalation'] ?? [] as $escIndex => $escalation
            ) {

                $entries = $this->factory->build(
                    $escalation,
                    $index,
                    $escIndex
                );

                if ($entries === []) {
                    $entries[] = TextEntry::make(
                        "fallback_{$index}_{$escIndex}"
                    )
                        ->hiddenLabel()
                        ->state('No channels configured');
                }

                $levelSections[] = Section::make(
                    'Level '.($escIndex + 1)
                    .' : '
                    .($escalation['name'] ?? 'Contact')
                )
                    ->compact()
                    ->secondary()
                    ->schema($entries);
            }

            $sections[] = Section::make(
                $item['title'] ?? 'Incident'
            )
                ->description(
                    $item['description'] ?? ''
                )
                ->icon(
                    $item['icon']
                        ?? 'heroicon-o-exclamation-circle'
                )
                ->schema([
                    Grid::make($columns)
                        ->schema($levelSections),
                ]);
        }

        return $sections;
    }
}
