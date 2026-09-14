<?php

declare(strict_types=1);

namespace Rimba\Foundation\Http\UI\Lobby\Pages;

use BackedEnum;
use Filament\Pages\Page;

class InductionPage extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'bites-l-induction';

    protected static ?string $navigationLabel = 'Orientation';

    protected static ?int $navigationSort = 2;

    protected static ?string $title = 'You need to be fully aware of these';

    protected string $view = 'bites::pages.simple';
}
