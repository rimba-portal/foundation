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

class EmergencyPage extends Page implements HasSchemas
{
    use InteractsWithSchemas;

    protected static string|UnitEnum|null $navigationGroup = 'Escalation';

    protected static string|BackedEnum|null $navigationIcon = 'bites-s-urgent';

    protected static ?string $navigationLabel = 'Emergency';

    protected static ?int $navigationSort = 63;

    protected static ?string $title = 'Emergency Response Escalation Matrix';

    protected string $view = 'bites::pages.call';

    public function contactInfolist(
        Schema $schema
    ): Schema {

        $escalationDataLoader = app(EscalationDataLoader::class);
        $escalationSchemaBuilder = app(EscalationSchemaBuilder::class);

        return $schema->schema(
            $escalationSchemaBuilder->build(
                $escalationDataLoader->get('emergency'),
                2,
                true
            )
        );
    }
}
