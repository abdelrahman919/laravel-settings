<?php 
namespace Hamada\Settings\Helpers;



/**
 * Class PathsHelper
 *
 * A helper class that provides utility methods for handling and managing file paths
 * within the Laravel settings package.
 */
class PathsHelper{

    // Store the migration file name to be later used for uninstallation etc.
    private static string $migrationFileName = '';

    public static function createMigrationFileName(): string
    {
/*         $fileName = date('Y_m_d_His', time()) . '_create_settings_table.php';
        self::$migrationFileName = $fileName; */
        $timestamp = now()->format('Y_m_d_His');
        $fileName = $timestamp . '_create_settings_table.php'; 
        self::$migrationFileName = $fileName; // Store the filename for later use
        return $fileName;
    }

    public static function getMigrationFileName(): string
    {
        return self::$migrationFileName;
    }

    public static function getPublishedDirsPaths(): array
    {
        return[
            'app/Hamada'
        ];
    }

    public static function getPublishedFilesPaths(): array
    {
        return [
            'database/Seeders/SettingsSeeder.php',
            'database/migrations/' . self::getMigrationFileName(),
        ];
    }


}