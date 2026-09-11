<?php

declare(strict_types=1);

namespace Rimba\Foundation\Http\UI\Staff\Schemas\Channels;

use Filament\Actions\Action;
use Illuminate\Support\HtmlString;

abstract class BaseEscalationChannel
{
    protected function qrAction(string $value): Action
    {
        return Action::make('qrcode')
            ->icon('heroicon-m-qr-code')
            ->modalHeading('Scan QR Code')
            ->modalWidth('sm')
            ->modalSubmitAction(false)
            ->modalCancelActionLabel('Close')
            ->modalContent(
                fn (): HtmlString => new HtmlString("
                    <div class='flex flex-col items-center p-6'>
                        &size=350'
                            class='w-64 h-64'
                        >
                        <p class='mt-3 text-xs break-all'>
                            {$value}
                        </p>
                    </div>
                ")
            );
    }
}
