<?php

declare(strict_types=1);

namespace Rimba\Foundation\Http\UI\Staff\Pages;

use BackedEnum;
use Rimba\Base\Pages\JsonTablePage;
use Rimba\Foundation\FoundationServiceProvider;
use UnitEnum;

class ToolsPage extends JsonTablePage
{
    protected static string $store = 'tools';

    protected static ?string $slug = 'tools';

    protected static ?string $title = 'Tools';

    protected static ?string $navigationLabel = 'Tools';

    protected static string|BackedEnum|null $navigationIcon =
        'heroicon-o-wrench-screwdriver';

    protected static string|UnitEnum|null $navigationGroup =
        'Resources';

    protected static function sourcePath(): string
    {
        return FoundationServiceProvider::jsonPath(
            static::$store
        );
    }
}
