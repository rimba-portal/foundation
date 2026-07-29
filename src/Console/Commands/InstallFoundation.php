<?php

declare(strict_types=1);

namespace Rimba\Foundation\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('rimba:install-foundation')]
#[Description('Install Rimba Foundation and configure Rimba Starter Kit')]
class InstallFoundation extends Command
{
    public function handle(): int
    {
        $isWindows = PHP_OS_FAMILY === 'Windows';

        $this->info('Detecting OS: '.($isWindows ? 'Windows' : 'Linux'));

        $this->info('Running Composer...');
        passthru('composer install');

        if (! file_exists(base_path('.env'))) {

            copy(
                base_path('.env.example'),
                base_path('.env')
            );

            $this->call('key:generate');
        }

        if ($isWindows) {

            $this->info('Configuring IIS permissions...');

            passthru('icacls "storage" /grant "IIS_IUSRS:(OI)(CI)(M)" /T /C');
            passthru('icacls "bootstrap\\cache" /grant "IIS_IUSRS:(OI)(CI)(M)" /T /C');
            passthru('icacls "database" /grant "IIS_IUSRS:(OI)(CI)(M)" /T /C');

        } else {

            $this->info('Configuring Linux permissions...');

            $webUser = is_dir('/etc/nginx')
                ? 'nginx'
                : 'apache';

            passthru(sprintf('sudo chown -R $USER:%s .', $webUser));
            passthru('find . -type d -exec chmod 755 {} \;');
            passthru('find . -type f -exec chmod 644 {} \;');
            passthru('sudo chmod -R 775 storage bootstrap/cache database');

            if (trim(shell_exec('getenforce 2>/dev/null')) === 'Enforcing') {

                $this->info('Updating SELinux policies...');

                passthru(
                    'sudo chcon -R -t httpd_sys_rw_content_t storage bootstrap/cache'
                );
            }
        }

        $this->publishWelcomePage();

        passthru('npm install --ignore-scripts');
        passthru('npm run build');

        $this->call('filament:install', [
            '--no-interaction' => true,
        ]);

        $this->call('migrate:fresh', [
            '--seed' => true,
            '--force' => true,
        ]);

        $this->call('optimize');
        $this->call('rimba:discover-rimba');

        $this->info('Rimba Starter Kit Installation Complete!');

        return self::SUCCESS;
    }

    protected function publishWelcomePage(): void
    {
        $source = base_path(
            'vendor/rimba/citra/resources/views/welcome.blade.php'
        );

        $target = resource_path('views/welcome.blade.php');

        if (! file_exists($source)) {
            return;
        }

        copy($source, $target);

        $this->info('Published welcome.blade.php');
    }
}
