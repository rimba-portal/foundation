<?php

declare(strict_types=1);

namespace Rimba\Foundation\Http\UI\Staff\Pages;

use BackedEnum;
use Rimba\Base\Pages\JsonTablePage;
use Rimba\Foundation\FoundationServiceProvider;
use UnitEnum;

class UnitsPage extends JsonTablePage
{
    protected static string $store = 'units';

    protected static ?string $slug = 'resources';

    protected static ?string $title = 'Resources';

    protected static ?string $navigationLabel = 'Units';

    protected static string|BackedEnum|null $navigationIcon =
        'heroicon-o-book-open';

    protected static string|UnitEnum|null $navigationGroup =
        'Resources';

    protected static ?int $navigationSort = 10;

    protected static function sourcePath(): string
    {
        return FoundationServiceProvider::jsonPath(
            static::$store
        );
    }
}
