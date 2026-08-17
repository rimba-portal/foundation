<?php

declare(strict_types=1);

namespace Rimba\Foundation;

use Illuminate\Console\Command;
use ReflectionClass;
use Rimba\Base\Services\BitesServiceProvider;
use Rimba\Foundation\Actions\DiscoverRimbaPackages;

class FoundationServiceProvider extends BitesServiceProvider
{
    protected string $configFile = __DIR__.'/../config/bites.php';

    protected string $iconsPath = __DIR__.'/../resources/svg';

    protected string $viewsPath = __DIR__.'/../resources/views';

    protected function bootPackage(): void
    {
        if ($this->app->runningInConsole()) {
            $this->registerCommandsFromDirectory();
        }

        app(DiscoverRimbaPackages::class)->cached();
    }

    protected function registerPackage(): void
    {
        //
    }

    /**
     * Dynamically discover and boot all commands inside the package directory.
     */
    protected function registerCommandsFromDirectory()
    {
        $commandDir = __DIR__.'/Console/Commands';
        if (! is_dir($commandDir)) {
            return;
        }

        $commands = [];
        foreach (glob($commandDir.'/*.php') as $file) {
            $className = basename($file, '.php');
            $class = 'Rimba\\Foundation\\Console\\Commands\\'.$className;
            if (class_exists($class) && is_subclass_of($class, Command::class)) {
                $reflection = new ReflectionClass($class);
                if (! $reflection->isAbstract()) {
                    $commands[] = $class;
                }
            }
        }

        if ($commands !== []) {
            $this->commands($commands);
        }
    }

    public static function jsonPath(string $store): string
    {
        return __DIR__."/../resources/json/{$store}.json";
    }
}
