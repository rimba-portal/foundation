<?php

declare(strict_types=1);

namespace Rimba\Foundation\Http\UI\Lobby\Pages;

use BackedEnum;
use Filament\Pages\Page;

class PolicyPage extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'bites-l-policy';

    protected static ?string $navigationLabel = 'Policy';

    protected static ?int $navigationSort = 3;

    protected static ?string $title = 'Policy';

    protected ?string $subheading = 'You must comply to company rules';

    protected string $view = 'bites::pages.simple';
}
