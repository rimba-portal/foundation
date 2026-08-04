<?php

declare(strict_types=1);

namespace Rimba\Foundation\Http\UI\Staff\Pages;

use BackedEnum;
use Filament\Pages\Page;
use UnitEnum;

class ReportAnIssuePage extends Page
{
    protected static string|UnitEnum|null $navigationGroup = 'Emergency';

    protected static string|BackedEnum|null $navigationIcon = 'bites-s-urgent';

    protected static ?string $navigationLabel = 'Report an issue';

    protected static ?int $navigationSort = 61;

    protected static ?string $title = 'Report an issue';

    protected ?string $subheading = 'Issue a fix ticket to OUs support group ie. IT, Facilities, etc.';

    protected string $view = 'bites::pages.simple';
}
