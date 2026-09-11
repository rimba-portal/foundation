<?php

declare(strict_types=1);

namespace Rimba\Foundation\Http\UI\Staff\Schemas\Channels;

use Filament\Actions\Action;
use Filament\Infolists\Components\TextEntry;

class EmailChannel extends BaseEscalationChannel
{
    public function make(string $name, array $config): TextEntry
    {
        $url = $config['cto'] ?? '#';

        return TextEntry::make($name)
            ->hiddenLabel()
            ->getStateUsing(
                fn () => $config['label']
            )

            ->prefixAction(
                Action::make("mail_{$name}")
                    ->icon('heroicon-m-envelope')
                    ->url($url)
                    ->openUrlInNewTab()
            )
            ->suffixAction(
                $this->qrAction($url)
            )
            ->color('primary');
    }
}
