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
        Schema::create(
            'system_setting_histories',
            function (Blueprint $table) {
                $table->id();

                /*
                |--------------------------------------------------------------------------
                | Related setting
                |--------------------------------------------------------------------------
                |
                | Nullable so that history can remain even when the
                | original setting record is later deleted.
                |
                */

                $table->foreignId('system_setting_id')
                    ->nullable()
                    ->constrained('system_settings')
                    ->nullOnDelete();

                /*
                |--------------------------------------------------------------------------
                | Setting identification snapshot
                |--------------------------------------------------------------------------
                |
                | We store group/key again intentionally.
                | This preserves useful history even if the original
                | system_settings record is removed.
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
                | Previous and new values
                |--------------------------------------------------------------------------
                */

                $table->longText(
                    'old_value'
                )->nullable();

                $table->longText(
                    'new_value'
                )->nullable();

                /*
                |--------------------------------------------------------------------------
                | Value type
                |--------------------------------------------------------------------------
                */

                $table->string(
                    'value_type',
                    30
                )->default('string');

                /*
                |--------------------------------------------------------------------------
                | Action
                |--------------------------------------------------------------------------
                |
                | Examples:
                |
                | created
                | updated
                | deleted
                | restored
                |
                */

                $table->string(
                    'action',
                    30
                )->default('updated');

                /*
                |--------------------------------------------------------------------------
                | User who made the change
                |--------------------------------------------------------------------------
                */

                $table->foreignId(
                    'changed_by'
                )
                    ->nullable()
                    ->constrained('users')
                    ->nullOnDelete();

                /*
                |--------------------------------------------------------------------------
                | Request information
                |--------------------------------------------------------------------------
                */

                $table->string(
                    'ip_address',
                    45
                )->nullable();

                $table->text(
                    'user_agent'
                )->nullable();

                /*
                |--------------------------------------------------------------------------
                | Optional request / operation information
                |--------------------------------------------------------------------------
                */

                $table->string(
                    'route_name',
                    150
                )->nullable();

                $table->string(
                    'request_method',
                    10
                )->nullable();

                /*
                |--------------------------------------------------------------------------
                | Extra metadata
                |--------------------------------------------------------------------------
                |
                | Allows future information to be stored without
                | changing this table structure.
                |
                */

                $table->json(
                    'metadata'
                )->nullable();

                /*
                |--------------------------------------------------------------------------
                | Timestamp
                |--------------------------------------------------------------------------
                |
                | History rows are append-only, so we only need
                | created_at instead of created_at + updated_at.
                |
                */

                $table->timestamp(
                    'created_at'
                )->useCurrent();

                /*
                |--------------------------------------------------------------------------
                | Indexes
                |--------------------------------------------------------------------------
                */

                $table->index(
                    [
                        'setting_group',
                        'setting_key',
                    ],
                    'setting_history_group_key_index'
                );

                $table->index(
                    'changed_by',
                    'setting_history_changed_by_index'
                );

                $table->index(
                    'action',
                    'setting_history_action_index'
                );

                $table->index(
                    'created_at',
                    'setting_history_created_at_index'
                );
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(
            'system_setting_histories'
        );
    }
};