<?php 

namespace App\Hamada\Settings\Http\Requests;

use App\Hamada\Settings\Models\Setting;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateSettingsRequest
 * 
 * Notes:
 * - Only the `value` field is validated based on the setting's validation rules,
 *   To update other fields, update them in the SettingsFactory,
 *   This is to separate the user update from the developer update.
 * 
 * - The `authorize` method can be customized to include specific authorization logic
 *   based on the application's security requirements.
 */
class UpdateSettingsRequest extends FormRequest
{

    private Setting $setting;

    protected function prepareForValidation(): void
    {
        // Requires model binding of the setting in the controller
        $this->setting = $this->route('setting');
    }

    /**
     * Use authority attribute of the setting in the request to authorize the user
     *
     * @return bool
     */
    public function authorize(): bool
    {
        /**
         * You can check if the user has the authority to update the setting, this varies based on the security system used in the application.:
         * $userAuth = $this->user()->hasAuthority($setting->authority);
         * $settingAuth = $this->setting->authority;
         * if ($settingAuth && $userAuth !== $settingAuth) {
         *     return false;
         * }
         */
        return true; 
    }



    public function rules(): array
    {
        return [
            'value' => $this->setting->validation_rules,
        ];
    }
}