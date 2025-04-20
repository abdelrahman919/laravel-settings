<?php

use App\Hamada\Settings\Enums\SettingsKeys;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->enum('key', SettingsKeys::getValues())->unique();
            $table->json('value')->nullable();
            $table->string('authority')->nullable();
            $table->string('type')->nullable();
            $table->string('validation_rules')->nullable();
            $table->string('group')->default('general');
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('settings');
    }
}

/* private SettingsKeys $key;
private string $defaultValue;
private string $authority;
private string $group;
private string $description;
private string $type;
private string $validationRules; */


