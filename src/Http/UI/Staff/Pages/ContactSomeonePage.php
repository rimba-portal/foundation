<?php

declare(strict_types=1);

namespace Rimba\Foundation\Http\UI\Staff\Pages;

use BackedEnum;
use Filament\Infolists\Components\TextEntry;
use Filament\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use UnitEnum;

class ContactSomeonePage extends Page implements HasSchemas
{
    use InteractsWithSchemas;

    protected static string|UnitEnum|null $navigationGroup = 'Emergency';

    protected static string|BackedEnum|null $navigationIcon = 'rimba-s-phone-call';

    protected static ?string $navigationLabel = 'Contact someone';

    protected static ?int $navigationSort = 62;

    protected static ?string $title = 'Contact someone';

    protected string $view = 'bites::pages.call';

    public function contactInfolist(Schema $schema): Schema
    {
        return $schema
            // Point state to config('bites.emergency')
            ->state(config('bites.emergency', []))
            ->schema([
                Section::make('Emergency Contacts')
                    ->description('Direct lines for immediate assistance')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                // Keys must match the keys inside config/bites.php['emergency']
                                TextEntry::make('ert')
                                    ->label('ERT')
                                    ->copyable(),
                                TextEntry::make('fire')
                                    ->label('Fire & Rescue')
                                    ->copyable(),
                                TextEntry::make('ambulance')
                                    ->label('Ambulance')
                                    ->copyable(),
                            ]),
                        TextEntry::make('security')
                            ->label('Security Command Center')
                            ->weight('bold')
                            ->copyable(),
                    ]),

            ]);
    }
}
