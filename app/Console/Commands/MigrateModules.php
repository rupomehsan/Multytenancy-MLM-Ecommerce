<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MigrateModules extends Command
{
    protected $signature = 'migrate:modules 
        {--module= : Target a specific module}
        {--seed : Seed module}
        {--seed-all : Seed all modules}
        {--path= : Additional path}
        {--force : Force}
        {--no-core : Skip core}
        {--pretend : Dry-run}
        {--fresh : Drop & re-run}';

    protected $description = 'Run migrations in app/Modules/* recursively';

    public function handle()
    {
        $modulesDir = app_path('Modules');
        $targetModule = $this->option('module');
        $extraPath = $this->option('path');
        $shouldSeed = $this->option('seed');
        $shouldSeedAll = $this->option('seed-all');
        $force = $this->option('force');
        $noCore = $this->option('no-core');
        $pretend = $this->option('pretend');
        $fresh = $this->option('fresh');

        if (!is_dir($modulesDir)) {
            $this->error("Modules directory not found: {$modulesDir}");
            return 1;
        }

        if ($fresh) {
            $this->warn('⚠ Dropping all tables...');
            $this->call('db:wipe', ['--force' => true]);
            $this->info('All tables dropped.');
            $this->line('');
        }

        $moduleMigrationPaths = $this->discoverModuleMigrations($modulesDir, $targetModule);
        if ($extraPath) $moduleMigrationPaths[] = $extraPath;

        $moduleMigrationPaths = array_values(array_unique($moduleMigrationPaths));

        // Sort: Users migrations first, then by path depth (shallow first)
        usort($moduleMigrationPaths, function ($a, $b) {
            $aHasUsers = stripos($a, '/Users/') !== false || stripos($a, 'UserManagements/Users') !== false;
            $bHasUsers = stripos($b, '/Users/') !== false || stripos($b, 'UserManagements/Users') !== false;

            if ($aHasUsers && !$bHasUsers) return -1;
            if (!$aHasUsers && $bHasUsers) return 1;

            return substr_count($a, DIRECTORY_SEPARATOR) - substr_count($b, DIRECTORY_SEPARATOR);
        });

        if ($fresh) {
            $this->runModuleMigrations($moduleMigrationPaths, $force, $pretend, $shouldSeed, $shouldSeedAll);
        }

        if (!$noCore) {
            $this->line('');
            $this->info('Running core migrations (database/migrations)');
            $params = [];
            if ($force) $params['--force'] = true;
            if ($pretend) $params['--pretend'] = true;
            $exitCode = $this->call('migrate', $params);
            if ($exitCode !== 0) return $exitCode;
        }

        if (!$fresh) {
            $this->runModuleMigrations($moduleMigrationPaths, $force, $pretend, $shouldSeed, $shouldSeedAll);
        }

        // If requested, run the application's main DatabaseSeeder (root seeder)
        if ($shouldSeedAll) {
            $this->line('');
            $this->info('Running application DatabaseSeeder');
            $seedParams = ['--force' => true];
            $this->call('db:seed', $seedParams);
        }

        return 0;
    }

    private function discoverModuleMigrations($modulesDir, $targetModule = null)
    {
        $paths = [];
        try {
            $rii = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($modulesDir, \RecursiveDirectoryIterator::SKIP_DOTS),
                \RecursiveIteratorIterator::SELF_FIRST
            );
            foreach ($rii as $file) {
                if ($file->isDir() && strcasecmp($file->getFilename(), 'migrations') === 0) {
                    $dirPath = $file->getPathname();
                    if ($targetModule) {
                        if (
                            stripos($dirPath, DIRECTORY_SEPARATOR . $targetModule . DIRECTORY_SEPARATOR) === false &&
                            stripos($dirPath, DIRECTORY_SEPARATOR . $targetModule) === false
                        ) {
                            continue;
                        }
                    }
                    $relative = str_replace(base_path() . DIRECTORY_SEPARATOR, '', $dirPath);
                    $relative = str_replace('\\', '/', $relative);
                    $paths[] = $relative;
                }
            }
        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
        }
        return $paths;
    }

    private function runModuleMigrations($paths, $force, $pretend, $shouldSeed, $shouldSeedAll)
    {
        if (empty($paths)) {
            $this->line('');
            $this->info('No module migrations found.');
            return;
        }

        $this->line('');
        $count = 0;
        foreach ($paths as $path) {
            $params = ['--path' => $path];
            if ($force) $params['--force'] = true;
            if ($pretend) $params['--pretend'] = true;

            $exitCode = $this->call('migrate', $params);
            if ($exitCode === 0) $count++;

            if ($shouldSeed || $shouldSeedAll) {
                $this->seedModule($path);
            }
        }

        $this->line('');
        $this->info($count > 0 ? "✓ Processed {$count} module paths." : '✓ All modules up to date.');
    }

    private function seedModule($foundPath)
    {
        // Split path using either slash to be robust across platforms
        $parts = preg_split('#[\\/]+#', $foundPath);
        $lower = array_map('strtolower', $parts);
        $moduleIndex = array_search('modules', $lower);

        if ($moduleIndex !== false && isset($parts[$moduleIndex + 1])) {
            $moduleName = $parts[$moduleIndex + 1];

            // Common module-level seeder location
            $seederFile = base_path("app/Modules/{$moduleName}/Database/Seeders/DatabaseSeeder.php");
            $class = "App\\Modules\\{$moduleName}\\Database\\Seeders\\DatabaseSeeder";

            if (is_file($seederFile)) {
                if (! class_exists($class)) require_once $seederFile;
                if (class_exists($class)) {
                    $this->info("Seeding: {$moduleName}");
                    $this->call('db:seed', ['--class' => $class, '--force' => true]);
                }
            }
        }
    }
}
