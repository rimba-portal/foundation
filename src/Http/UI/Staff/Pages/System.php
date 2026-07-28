<?php

declare(strict_types=1);

namespace Rimba\Foundation\Http\UI\Staff\Pages;

use BackedEnum;
use Filament\Pages\Page;
use UnitEnum;

class System extends Page
{
    protected static string|UnitEnum|null $navigationGroup = 'Accountables';

    // protected static string|BackedEnum|null $navigationIcon = 'bites-asset-own';

    protected static ?string $navigationLabel = 'Assigned Assets';

    protected static ?int $navigationSort = 22;

    protected static ?string $title = 'Assigned Assets';

    protected ?string $subheading = 'Asset/Equipment/Items issued to you or your support group.';

    protected string $view = 'bites.pages.simple';

    protected function getHeaderWidgets(): array
    {
        return [
            // \App\Filament\Staff\Widgets\UserRolesWidget::class,
            // \App\Filament\Hrm\Resources\Staff\Widgets\ShiftMixByOrgUnitTable::class,
        ];
    }

    public static function myclass(): string
    {
        // Late static binding: resolves to the calling class
        return static::class;          // e.g., App\Models\User
    }
}
