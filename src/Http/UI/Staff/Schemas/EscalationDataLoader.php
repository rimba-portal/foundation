<?php

declare(strict_types=1);

namespace Rimba\Foundation\Http\UI\Staff\Schemas;

class EscalationDataLoader
{
    public function load(): array
    {
        $file = storage_path('app/private/escalation.json');

        if (! file_exists($file)) {
            return [];
        }

        return json_decode(
            file_get_contents($file),
            true
        ) ?? [];
    }

    public function get(string $category): array
    {
        return $this->load()[$category] ?? [];
    }
}
