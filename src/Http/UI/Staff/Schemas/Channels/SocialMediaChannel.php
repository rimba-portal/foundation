<?php

declare(strict_types=1);

namespace Rimba\Foundation\Http\UI\Staff\Schemas\Channels;

use Filament\Actions\Action;
use Filament\Infolists\Components\TextEntry;

class SocialMediaChannel extends BaseEscalationChannel
{
    public function make(string $name, array $config): TextEntry
    {

        $url = $config['cto'] ?? '#';

        return TextEntry::make($name)
            ->hiddenLabel()
            ->getStateUsing(
                fn () => $config['label']
                    ?? 'Social Media'
            )
            ->prefixAction(
                Action::make("open_{$name}")
                    ->icon('heroicon-m-chat-bubble-left-right')
                    ->url($url)
                    ->openUrlInNewTab()
            )
            ->suffixAction(
                $this->qrAction($url)
            )
            ->color('success');
    }
}
