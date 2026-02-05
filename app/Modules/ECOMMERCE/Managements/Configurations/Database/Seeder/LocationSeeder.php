<?php

namespace App\Modules\ECOMMERCE\Managements\Configurations\Database\Seeder;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Path to the SQL file within the Configurations module
        $sqlFile = __DIR__ . '/../Migrations/location.sql';

        if (!file_exists($sqlFile)) {
            $this->command->error("SQL file not found at: {$sqlFile}");
            return;
        }

        $this->command->info('Importing location data from SQL file...');

        // Read the SQL file
        $sql = file_get_contents($sqlFile);

        // Fix column name mismatch: upazilla_id -> upazila_id
        $sql = str_replace('upazilla_id', 'upazila_id', $sql);

        // Fix line break issues in SQL keywords (normalize line breaks first)
        $sql = str_replace(["\r\n", "\r"], "\n", $sql);

        // Remove MySQL comments
        $sql = preg_replace('/\/\*.*?\*\//s', '', $sql);
        $sql = preg_replace('/^--[^\n]*$/m', '', $sql);

        // Now replace newlines with spaces, BUT preserve semicolons with newlines for splitting
        // This ensures statements are properly separated
        $sql = str_replace(';', ";\n", $sql);
        $sql = preg_replace('/\n+/', ' ', $sql);
        $sql = str_replace('; ', ";\n", $sql);

        // Split into individual statements by newlines (each statement ends with ;\n)
        $statements = array_filter(
            array_map('trim', explode("\n", $sql)),
            function ($stmt) {
                // Filter out empty statements, comments, and lone semicolons
                return !empty($stmt) &&
                    $stmt !== ';' &&
                    !preg_match('/^(\/\*|--|\s*$|;+\s*$)/', $stmt);
            }
        );

        // Execute each statement
        $successCount = 0;
        $errorCount = 0;
        $skippedCount = 0;

        foreach ($statements as $statement) {
            // Skip DDL statements (CREATE, ALTER, DROP, etc.) since tables exist from migrations
            $upperStatement = strtoupper(substr(ltrim($statement), 0, 50));
            if (
                strpos($upperStatement, 'CREATE TABLE') !== false ||
                strpos($upperStatement, 'ALTER TABLE') !== false ||
                strpos($upperStatement, 'DROP TABLE') !== false ||
                strpos($upperStatement, 'SET SQL_MODE') !== false ||
                strpos($upperStatement, 'SET TIME_ZONE') !== false ||
                strpos($upperStatement, 'START TRANSACTION') !== false ||
                strpos($upperStatement, 'COMMIT') !== false ||
                strpos($upperStatement, 'SET @') !== false ||
                strpos($upperStatement, '/*!') !== false
            ) {
                $skippedCount++;
                continue;
            }

            try {
                DB::unprepared($statement);
                $successCount++;
            } catch (\Exception $e) {
                $errorCount++;
                $this->command->warn("Failed to execute statement: " . substr($statement, 0, 100) . "...");
                $this->command->warn("Error: " . $e->getMessage());
            }
        }

        $this->command->info("Location data import completed!");
        $this->command->info("Successful: {$successCount}, Failed: {$errorCount}, Skipped DDL: {$skippedCount}");
    }
}
