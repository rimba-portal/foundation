<?php

declare(strict_types=1);

namespace Rimba\Foundation\Http\UI\Staff\Resources;

use BackedEnum;
use Rimba\Base\Resources\JsonResource;

class SystemResource extends JsonResource
{
    protected static string $store = 'systems';

    protected static ?string $modelLabel = 'Application System';

    protected static string|BackedEnum|null $navigationIcon =
        'heroicon-o-key';
}
