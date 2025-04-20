<?php

namespace App\Hamada\Settings\Models;

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


    // Values are stored as json in the database since they can be of any type
    // so we need to decode them before returning them
    public function getValueAttribute()
    {
        $decodedArray = json_decode($this->attributes['value'], true);
        return $decodedArray['value'];
    }

    public function setValueAttribute($value)
    {
        $this->attributes['value'] = json_encode(['value' => $value]);
    }
}
