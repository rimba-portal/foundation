<?php

declare(strict_types=1);

namespace Rimba\Foundation\Http\UI\Staff\Resources;

use BackedEnum;
use Rimba\Base\Resources\JsonResource;
use UnitEnum;

class UnitResource extends JsonResource
{
    protected static string $store = 'units';

    protected static string|UnitEnum|null $navigationGroup = 'Resources';

    protected static string|BackedEnum|null $navigationIcon = 'bites-asset-own';

    protected static ?string $navigationLabel = 'Assigned Assets';

    protected static ?int $navigationSort = 122;

    protected static ?string $title = 'Assigned Assets';

    protected ?string $subheading = 'Asset/Equipment/Items issued to you or your support group.';

    protected static ?string $modelLabel = 'Resourceus';
}
