<?php

declare(strict_types=1);

namespace Rimba\Foundation\Http\UI\Staff\Schemas;

class EscalationChannelFactory
{
    public function build(
        array $escalation,
        int $index,
        int $escIndex
    ): array {

        $channels = [
            'smp' => Channels\SocialMediaChannel::class,
            'email' => Channels\EmailChannel::class,
            'map' => Channels\MapChannel::class,
            'call' => Channels\CallChannel::class,
        ];

        $entries = [];

        foreach ($channels as $key => $class) {

            if (empty($escalation[$key])) {
                continue;
            }

            $entries[] = app($class)
                ->make(
                    "{$key}_{$index}_{$escIndex}",
                    $escalation[$key]
                );
        }

        return $entries;
    }
}
