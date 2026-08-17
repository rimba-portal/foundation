<?php

declare(strict_types=1);

namespace Rimba\Foundation\Http\UI\Staff\Resources;

use BackedEnum;
use Rimba\Base\Resources\JsonResource;
use Rimba\Foundation\Http\UI\Staff\Resources\Pages\ManageSystems;

class SystemResource extends JsonResource
{
    protected static string $store = 'systems';

    protected static ?string $modelLabel =
        'Application System';

    protected static string|BackedEnum|null $navigationIcon =
        'heroicon-o-key';

    public static function getPages(): array
    {
        return [
            'index' => ManageSystems::route('/'),
        ];
    }
}
