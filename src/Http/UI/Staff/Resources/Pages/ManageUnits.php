<?php

declare(strict_types=1);

namespace Rimba\Foundation\Http\UI\Staff\Resources\Pages;

use Filament\Resources\Pages\ListRecords;
use Rimba\Foundation\Http\UI\Staff\Resources\UnitResource;

class ManageUnits extends ListRecords
{
    protected static string $resource =
        UnitResource::class;
}
