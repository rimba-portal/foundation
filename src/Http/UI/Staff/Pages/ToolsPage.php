<?php

declare(strict_types=1);

namespace Rimba\Foundation\Http\UI\Staff\Pages;

use BackedEnum;
use Filament\Support\Icons\Heroicon;
use Rimba\Base\Pages\JsonTablePage;
use Rimba\Foundation\FoundationServiceProvider;
use UnitEnum;

class ToolsPage extends JsonTablePage
{
    protected static string $store = 'tools';

    protected static ?string $title = 'Tools';

    protected static string|UnitEnum|null $navigationGroup = 'Knowledge';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ArrowSmallRight;

    protected ?string $subheading = '';

    protected static ?string $navigationLabel = 'Tools';

    protected static ?int $navigationSort = 22;

    protected static function sourcePath(): string
    {
        return FoundationServiceProvider::jsonPath(
            static::$store
        );
    }
}
