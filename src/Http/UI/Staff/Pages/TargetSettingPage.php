<?php

declare(strict_types=1);

namespace Rimba\Foundation\Http\UI\Staff\Pages;

use BackedEnum;
use Filament\Pages\Page;
use UnitEnum;

class TargetSettingPage extends Page
{
    protected static string|UnitEnum|null $navigationGroup = 'ToDo';

    protected static string|BackedEnum|null $navigationIcon = 'bites-s-target';

    protected static ?string $navigationLabel = 'Target Setting';

    protected static ?int $navigationSort = 13;

    protected static ?string $title = 'Target Setting';

    protected ?string $subheading = 'Target settings and progress overview for your work.';

    protected string $view = 'bites::pages.simple';
}
