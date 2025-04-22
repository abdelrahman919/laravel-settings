<?php

namespace Hamada\Settings\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';
    public $timestamps = true;
    protected $fillable = [
        'key',
        'value',
        'authority',
        'type',
        'validation_rules',
        'group',
        'description',
    ];

    protected $casts = [
        'value' => 'json',
    ];

    /**
     * Values are stored as json in the database since they can be of any type
     * so we need to decode them before returning them
     */
    public function getValueAttribute()
    {
        $decodedArray = json_decode($this->attributes['value'], true);
        return $decodedArray['value'];
    }


    /**
     * Set the value attribute for the setting.
     *
     * This method ensures that the provided value matches the expected type
     * defined by the `type` property of the model. If the types do not match,
     * an InvalidArgumentException is thrown.
     * The value is then encoded as JSON and stored in the `value` attribute.
     *
     * @param mixed $value The value to be set for the setting.
     * 
     * @throws \InvalidArgumentException If the type of the provided value does not match the expected type.
     */
    public function setValueAttribute($value)
    {
        $expectedType = $this->type;
        $actualType = gettype($value);

        if ($expectedType !== $actualType) {
            throw new \InvalidArgumentException("Invalid type for setting {$this->key}. Expected {$expectedType}, got {$actualType}");
        }

        $this->attributes['value'] = json_encode(['value' => $value]);
    }
}
