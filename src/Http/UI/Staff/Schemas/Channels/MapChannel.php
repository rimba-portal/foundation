<?php

declare(strict_types=1);

namespace Rimba\Foundation\Http\UI\Staff\Schemas\Channels;

use Filament\Actions\Action;
use Filament\Infolists\Components\TextEntry;

class MapChannel extends BaseEscalationChannel
{
    public function make(
        string $name,
        array $config
    ): TextEntry {

        $url = $config['cto'] ?? '#';

        return TextEntry::make($name)
            ->hiddenLabel()
            ->getStateUsing(
                fn () => $config['label']
            )
            ->url($url)
            ->openUrlInNewTab()
            ->prefixAction(
                Action::make("map_{$name}")
                    ->icon('heroicon-m-map-pin')
            )
            ->suffixAction(
                $this->qrAction($url)
            )
            ->color('info');
    }
}
