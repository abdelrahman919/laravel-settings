<?php

namespace App\Hamada\Settings\Factories;

use App\Hamada\Settings\Enums\SettingsGroups;
use Hamada\Settings\Models\Setting;
use App\Hamada\Settings\Enums\SettingsKeys;


/**
 * Class SettingsConfigFactory
 * 
 * Add new Settings defaults in the getDefaults() method.
 *  
 */
class SettingsConfigFactory
{

    /**
     * Get the default settings for the application.
     * 
     * Add more default settings as needed.
     *
     * @return Setting[]
     */
    public static function getDefaults(): array
    {
        return [
            /**
             * Example of creating a new Setting:
             */
            
            /* new Setting([
                'key' => SettingsKeys::APP_NAME->value, // The key of the setting, should be an enum value
                'value' => 'My Application', // The value of the setting, could be any type
                'type' => 'string', // The type of the setting, could be 'string', 'integer', 'boolean', etc.
                'authority' => 'admin', // Optional, who has authority over this setting
                'validation_rules' => 'required|string|max:255', // Optional, validation rules for the setting
                'group' => SettingsGroups::General->value, // Optional, default is 'general'
                'description' => 'The name of the application', // Optional, description of the setting
            ]) */

            // Add more default settings as needed
        ];
    }
}
