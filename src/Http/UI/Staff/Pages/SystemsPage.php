<?php

declare(strict_types=1);

namespace Rimba\Foundation\Http\UI\Staff\Pages;

use BackedEnum;
use Rimba\Base\Pages\JsonTablePage;
use Rimba\Foundation\FoundationServiceProvider;
use UnitEnum;

class SystemsPage extends JsonTablePage
{
    protected static string $store = 'systems';

    protected static ?string $slug = 'systems.apps';

    protected static ?string $title = 'Application Systems';

    protected static string|UnitEnum|null $navigationGroup = 'Systems';

    protected static string|BackedEnum|null $navigationIcon = 'bites-softwares';

    protected ?string $subheading = 'Request for support, service, item, asset, equipment, etc. through workflow system.';

    protected static ?string $navigationLabel = 'Application';

    protected static ?int $navigationSort = 10;

    protected static function sourcePath(): string
    {
        return FoundationServiceProvider::jsonPath(
            static::$store
        );
    }
}
