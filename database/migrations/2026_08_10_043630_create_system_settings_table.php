<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Setting identification
            |--------------------------------------------------------------------------
            |
            | Examples:
            |
            | setting_group = general
            | setting_key   = system_name
            |
            | setting_group = localization
            | setting_key   = default_locale
            |
            */

            $table->string(
                'setting_group',
                100
            );

            $table->string(
                'setting_key',
                150
            );

            /*
            |--------------------------------------------------------------------------
            | Setting value
            |--------------------------------------------------------------------------
            |
            | longText allows the Settings Center to store:
            |
            | - ordinary strings
            | - long text
            | - integers as serialized text
            | - booleans
            | - JSON
            | - URLs
            | - file paths
            | - image paths
            |
            */

            $table->longText(
                'setting_value'
            )->nullable();

            /*
            |--------------------------------------------------------------------------
            | Value type
            |--------------------------------------------------------------------------
            |
            | Supported values will include:
            |
            | string
            | text
            | integer
            | decimal
            | boolean
            | json
            | email
            | url
            | color
            | date
            | time
            | file
            | image
            |
            */

            $table->string(
                'value_type',
                30
            )->default('string');

            /*
            |--------------------------------------------------------------------------
            | Visibility
            |--------------------------------------------------------------------------
            |
            | Public settings may safely be exposed to application views.
            |
            | Sensitive environment information such as:
            |
            | APP_KEY
            | DB_PASSWORD
            | MAIL_PASSWORD
            |
            | will never be stored through this Settings Center.
            |
            */

            $table->boolean(
                'is_public'
            )->default(false);

            /*
            |--------------------------------------------------------------------------
            | Description
            |--------------------------------------------------------------------------
            */

            $table->text(
                'description'
            )->nullable();

            /*
            |--------------------------------------------------------------------------
            | Last user who changed the setting
            |--------------------------------------------------------------------------
            */

            $table->foreignId(
                'updated_by'
            )
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Laravel timestamps
            |--------------------------------------------------------------------------
            */

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Constraints and indexes
            |--------------------------------------------------------------------------
            |
            | A setting key may exist only once inside each group.
            |
            | Example:
            |
            | general + system_name
            |
            | cannot be duplicated.
            |
            */

            $table->unique(
                [
                    'setting_group',
                    'setting_key',
                ],
                'system_settings_group_key_unique'
            );

            $table->index(
                'setting_group',
                'system_settings_group_index'
            );

            $table->index(
                'is_public',
                'system_settings_public_index'
            );

            $table->index(
                'value_type',
                'system_settings_type_index'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(
            'system_settings'
        );
    }
};