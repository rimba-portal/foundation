<?php

declare(strict_types=1);

namespace Rimba\Foundation\Http\UI\Lobby\Pages;

use BackedEnum;
use Filament\Pages\Page;

class InductionPage extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'bites-l-induction';

    protected static ?string $navigationLabel = 'Induction';

    protected static ?int $navigationSort = 2;

    protected static ?string $title = 'Orientation';

    protected ?string $subheading = 'You need to be fully aware of these';

    protected string $view = 'bites::pages.simple';
}
