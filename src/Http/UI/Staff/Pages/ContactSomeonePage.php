<?php

declare(strict_types=1);

namespace Rimba\Foundation\Http\UI\Staff\Pages;

use BackedEnum;
use Filament\Pages\Page;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Rimba\Foundation\Http\UI\Staff\Schemas\EscalationDataLoader;
use Rimba\Foundation\Http\UI\Staff\Schemas\EscalationSchemaBuilder;
use UnitEnum;

class ContactSomeonePage extends Page implements HasSchemas
{
    use InteractsWithSchemas;

    protected static string|UnitEnum|null $navigationGroup = 'Escalation';

    protected static string|BackedEnum|null $navigationIcon = 'bites-s-phone-call';

    protected static ?string $navigationLabel = 'Contact Someone';

    protected static ?int $navigationSort = 62;

    protected static ?string $title = 'Emergency Response Level Matrix';

    protected string $view = 'bites::pages.call';

    public function contactInfolist(
        Schema $schema,
        EscalationDataLoader $loader,
        EscalationSchemaBuilder $builder,
    ): Schema {

        return $schema
            ->schema(
                $builder->build(
                    $loader->get('sensitive'),
                    3,
                )
            );
    }
}
