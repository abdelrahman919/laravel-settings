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
        $fileName = date('Y_m_d_His', time()) . '_create_settings_table.php';
        self::$migrationFileName = $fileName;
        return $fileName;
    }

    public static function getMigrationFileName(): string
    {
        return self::$migrationFileName;
    }

    public static function getPackageAppPath(): string
    {
        return __DIR__ . '/../App/';
    }

    private static function getDatabasePath(): string
    {
        return __DIR__ . '/../Database/';
    }

    public static function getMigrationsPath(): string
    {
        return self::getDatabasePath() . 'migrations/';
    }

    public static function getSeedersPath(): string
    {
        return self::getDatabasePath() . 'Seeders/';
    }

    public static function getRoutesPath(): string
    {
        return __DIR__ . '/../routes/api.php';
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