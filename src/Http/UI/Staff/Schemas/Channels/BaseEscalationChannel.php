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
            ->modalContent(function () use ($value): HtmlString {
                // Safely grab the URL value from your loop context

                return new HtmlString('
                    <div class="flex flex-col items-center justify-center p-6 text-center">
                        <div class="p-3 bg-white rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                            <img 
                                src="https://quickchart.io/qr?text='.urlencode($value).'&size=350" 
                                alt="QR code to scan" 
                                class="w-64 h-64 object-contain mx-auto"
                            />
                        </div>
                        <p class="mt-4 text-sm text-gray-500 dark:text-gray-400 break-all max-w-xs">
                            '.e($value).'
                        </p>
                    </div>
                ');
            });
    }
}
