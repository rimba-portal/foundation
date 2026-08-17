<?php

declare(strict_types=1);

namespace Rimba\Foundation\Http\UI\Staff\Resources\Pages;

use Filament\Resources\Pages\ListRecords;
use Rimba\Foundation\Http\UI\Staff\Resources\SystemResource;

class ManageSystems extends ListRecords
{
    protected static string $resource =
        SystemResource::class;
}
