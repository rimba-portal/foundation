<?php

declare(strict_types=1);

namespace Rimba\Foundation\Actions;

use FilesystemIterator;
use Illuminate\Support\Facades\Cache;

class DiscoverRimbaPackages
{
    protected string $cacheKey = 'rimba_packages';

    public function execute(bool $forceRefresh = false): array
    {
        if ($forceRefresh) {
            Cache::forget($this->cacheKey);
        }

        return Cache::rememberForever($this->cacheKey, function (): array {
            $vendorPath = base_path('vendor/rimba');

            if (! is_dir($vendorPath)) {
                return [];
            }

            $packages = [];

            foreach (
                new FilesystemIterator(
                    $vendorPath,
                    FilesystemIterator::SKIP_DOTS
                ) as $package
            ) {
                if (! $package->isDir()) {
                    continue;
                }

                $packageName = $package->getFilename();
                $srcPath = $package->getPathname().'/src';

                $packages[$packageName] = $this->discoverProvider($srcPath);
            }

            ksort($packages);

            return $packages;
        });
    }

    protected function discoverProvider(string $srcPath): ?string
    {
        if (! is_dir($srcPath)) {
            return null;
        }

        foreach (
            new FilesystemIterator(
                $srcPath,
                FilesystemIterator::SKIP_DOTS
            ) as $file
        ) {
            if (
                $file->isFile() &&
                str_ends_with(
                    $file->getFilename(),
                    'ServiceProvider.php'
                )
            ) {
                return str_replace(
                    'ServiceProvider',
                    '',
                    pathinfo(
                        $file->getFilename(),
                        PATHINFO_FILENAME
                    )
                );
            }
        }

        return null;
    }
}
