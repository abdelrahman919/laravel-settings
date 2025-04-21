<?php

namespace Hamada\Settings\Helpers;

use Illuminate\Support\Facades\File;



/**
 * Class PathsHelper
 *
 * A helper class that provides utility methods for handling and managing file paths
 * within the Laravel settings package.
 */
class PathsHelper
{

    public static function createMigrationFileName(): string
    {
        // Generate a timestamp for the migration file name
        $timestamp = now()->format('Y_m_d_His');
        $fileName = $timestamp . '_create_settings_table.php';
        return $fileName;
    }


    public static function getPublishedDirsPaths(): array
    {
        return [
            'app/Hamada'
        ];
    }

    public static function getPublishedFilesPaths(): array
    {
        return [
            'database/Seeders/SettingsSeeder.php',
            'database/migrations/' . self::getPublishedMigration(),
        ];
    }

    public static function getPublishedMigration(): ?string
    {
        $migrationDirectory = database_path('migrations');

        // Get the list of migration files in the migrations directory
        $migrationFiles = File::files($migrationDirectory);

        // Optionally, filter the files to find the migration file you just published
        $publishedMigration = collect($migrationFiles)->filter(function ($file) {
            return strpos($file->getFilename(), 'create_settings_table') !== false;
        })->first();

        // Return the name of the published migration
        return $publishedMigration ? $publishedMigration->getFilename() : null;
    }
}
