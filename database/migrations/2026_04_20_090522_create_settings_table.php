<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();

            $table->string('system_name')->default('Executive Management Information System');
            $table->string('system_short_name')->default('EMIS');
            $table->string('default_language')->default('en');
            $table->string('timezone')->default('Asia/Kabul');
            $table->string('date_format')->default('Y-m-d');
            $table->text('system_description')->nullable();

            $table->string('organization_name')->nullable();
            $table->string('department_name')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();

            $table->boolean('enable_user_registration')->default(true);
            $table->boolean('enable_task_notifications')->default(true);
            $table->boolean('enable_document_tracking')->default(true);
            $table->boolean('email_notifications')->default(false);
            $table->boolean('browser_notifications')->default(true);

            $table->unsignedTinyInteger('password_min_length')->default(8);
            $table->unsignedInteger('session_timeout')->default(30);

            $table->boolean('maintenance_mode')->default(false);
            $table->boolean('debug_mode')->default(false);

            $table->string('logo_path')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};