# Strongly Typed Application Settings
**Clarification:** The package has no stable releases yet.

This package allows you to store settings with type checking and reuse them easily across your application.
It also provides optional additional form request validation rules for more fine grained control of your settings structure. 

# Index

### 1. [How To Install](#installation)

### 2. [How It Works (quick rundown)](#how-it-works)

### 3. [Hot To Use](#usage):
 1. [Internal (within app)](#internal-usage)
 2. [External (with controllers)](#external-usage)

### 4. [Commands ](#commands)

### 5. [Deep  Dive](#deep-dive)

<br>

## Installation

 1. Install via Composer:
  
		composer require abdelrahman919/laravel-settings:dev-main
		

 2. Publish necessary files:

		php artisan settings:publish
    
   3. Migrate the settings migration:
   

		  php artisan settings:migrate

<br>

## How It Works

 1. Each Setting instance has multiple attributes including a unique key, value and type.
 2. the model stores the values as json preserving the type.
 3. Accessors are used in the Setting model for both getters and setters of the value.
 4. You populate a factory with all the Setting instances along with their attributes' default values.
 5. A simple seed commands seed the database directly using the factory.
 6. If the developer or the customer later want to update the value of any setting you can use customizable predefined methods in the controller.
 7. To change other attributes such as authority or validation rules you change them in the factory and run the seed command to update the setting entry in the database.

<br>

## Usage:
Under app\Hamada you should find the published directories which will be used to create and store settings.

 - **Notes:**
     - The value of a setting is recommended to be updated **ONLY** via controller.
     - Other attributes are updated internally as will be explained.

**First, the internal usage of the package within the application is discussed, followed by its interaction with the front-end.**



## Internal Usage

1. In **app\Hamada\Settings\Enums**  you will find SettingsKeys enum, In this Enum create your setting keys (names).
- Enums are used for Settings keys to eliminate the error prone nature of dealing with strings.
					
		enum  SettingsKeys: string

		{
			/**

			* Example enum cases:

			* case APP_NAME = 'app_name';

			*/

		}
<br>

2. Head to **app\Hamada\Factories**  and in SettingsConfigFactory add the default attributes for your setting in the getDefaults() method.
- If you later want to change attributes OTHER THAN VALUE you can change them in here and run the seed command.

	   public  static  function  getDefaults(): array

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
<br>


3. After you added the default values for your settings now run the seed command to seed them directly into the data base:

	   php artisan settings:seed
	   
<br>

4. Now your settings are stored and ready to use anywhere in your application using the Settings facade:
for example: 

	   $setting = Settings:getValue(SettingsKeys::APP_NAME->value)
	   

|Facade Function |Usage|  
|--|--|
getValue(string  $key)|Get only the value of the setting
|getSetting(string  $key): ?Setting  |Get the entire Setting object or NULL if no setting with provided key exists| 
|getAllSettings(?string  $group = null): Collection | Get all stored settings optionally filtered by group

## External Usage
The recommended method for **value** updates since it goes through the form request validations.




 1. In **app\Hamada\Http\Controllers** You will find SettingsController with pre defined index, show, showByKey and udpate functions.
	 **Note:** 
	 -  Update functoin only updates the value 
	- Since controller is published you can customize the JSON payload as you would like.
 
2. In **app\Hamada\Http\Requests** you will find the UpdateSettingsRequest.
- It is responsible for validating the value against the rules assigned in the config factory using model binding to fetch the setting instance.

		private  Setting  $setting;

		protected  function  prepareForValidation(): void
		{
			// Requires model binding of the setting in the controller
			$this->setting = $this->route('setting');
		}
		

- It also check if the user is authorized to perform the update on this specific setting  which is customizable via the authority attribute in the Setting instance.
The implementation of the method is left to the developer based on the security package used in their app.
 
		public  function  authorize(): bool
			{
				/**
				* You can check if the user has the authority to update the setting, this varies based on the security system used in the application.:
				* for example:
				* 
				* $userAuth = $this->user()->hasAuthority($setting->authority);
				* $settingAuth = $this->setting->authority;
				* if ($settingAuth && $userAuth !== $settingAuth) {
				* return false;
				* }
				*/
				return  true;

			}
<br>

## Commands

|Command|Option  |Usage  |
|--|--|--|
|`php artisan settings:uninstall`  |  | Unistall the package using composer. <br> Delete published files and directories.
 |	| `--rollback` | Roll back the published migrations.
  `php artisan settings:publish`||Publish relative package files.|
  |`php artisan settings:migrate`|| Migrate the published settings table migratoin.
  |`php artisan settings:seed`|| Seed the settings default values to data base using the SettingsConfigFactory getDefaults() method.


<br>

 ## Deep Dive:
 

 - The Settings Facade uses the SettingsService class:
			 
		class  Settings  extends  Facade
		{
				/**
				* Get the registered name of the component.
				*
				* @return  string
				*/
				protected  static  function  getFacadeAccessor()
				{
				return  'settings-service';;
				}
		}


	Which in turn is registered as singelton in the SettingsServiceProvider:

		$this->app->singleton('settings-service', function ($app) {
		return  new  SettingsService();
		});

- The Setting model stores the value as json to keep its original value and type and relies on accessors to get and set the value:

	  public  function  getValueAttribute()
	  {
		  $decodedArray = json_decode($this->attributes['value'], true);
		  return  $decodedArray['value'];
	  }

	The setter relies on the type attribute to insure the type is not mismatched if setter is used out of controller update method.
	
	  public  function  setValueAttribute($value)
	  {
		  $expectedType = $this->type;
		  $actualType = gettype($value);
			if ($expectedType !== $actualType) {

			throw  new  \InvalidArgumentException("Invalid type for setting {$this->key}. Expected {$expectedType}, got {$actualType}");
			}
			$this->attributes['value'] = json_encode(['value' => $value]);
	  }


					 
				

			
