<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('budget_entities', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Identification
            |--------------------------------------------------------------------------
            */

            $table->string('entity_code', 50)->unique();

            $table->string('name_en')->nullable();
            $table->string('name_ps')->nullable();
            $table->string('name_fa');

            $table->string('short_name', 100)->nullable();

            /*
            |--------------------------------------------------------------------------
            | Classification
            |--------------------------------------------------------------------------
            */

            $table->string('entity_type', 50)
                ->default('budget_unit');

            /*
            |--------------------------------------------------------------------------
            | Hierarchy
            |--------------------------------------------------------------------------
            |
            | Stored as an indexed ID without a database foreign key so this
            | migration remains compatible with the current EMIS database.
            |
            */

            $table->unsignedBigInteger('parent_id')
                ->nullable()
                ->index();

            /*
            |--------------------------------------------------------------------------
            | Contact details
            |--------------------------------------------------------------------------
            */

            $table->string('phone', 50)->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Administrative information
            |--------------------------------------------------------------------------
            */

            $table->boolean('status')->default(true);
            $table->text('description')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Record ownership
            |--------------------------------------------------------------------------
            |
            | Kept as an indexed ID without a foreign key to avoid a type or
            | storage-engine mismatch with the existing users table.
            |
            */

            $table->unsignedBigInteger('created_by')
                ->nullable()
                ->index();

            $table->timestamps();
            $table->softDeletes();

            /*
            |--------------------------------------------------------------------------
            | Search indexes
            |--------------------------------------------------------------------------
            */

            $table->index('entity_type');
            $table->index('status');
            $table->index('name_en');
            $table->index('name_fa');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('budget_entities');
    }
};
