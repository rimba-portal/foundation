<?php

declare(strict_types=1);

namespace Rimba\Foundation\Http\UI\Staff\Schemas\Channels;

use Filament\Actions\Action;
use Filament\Infolists\Components\TextEntry;

class CallChannel
{
    public function make(
        string $name,
        array $config
    ): TextEntry {

        return TextEntry::make($name)
            ->hiddenLabel()
            ->getStateUsing(
                fn () => $config['label']
            )
            ->url(
                $config['cto'] ?? '#'
            )
            ->prefixAction(
                Action::make("call_{$name}")
                    ->icon('heroicon-m-phone')
            )
            ->color('warning');
    }
}
