<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('focal_points', function (Blueprint $table) {
            $table->id();

            /*
             * budget_entities and users are existing EMIS tables.
             * Keep compatible indexed IDs without external foreign keys.
             */
            $table->unsignedBigInteger('budget_entity_id')->index();

            /*
             * This table is created by this module, so this FK is safe.
             */
            $table->foreignId('introduction_id')
                ->constrained('focal_point_introductions')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->unsignedBigInteger('user_id')->nullable()->index();

            $table->string('focal_point_code', 100)->unique();

            $table->string('full_name_en')->nullable();
            $table->string('full_name_ps')->nullable();
            $table->string('full_name_fa');

            $table->string('father_name');
            $table->string('grandfather_name')->nullable();
            $table->string('employee_number', 100)->nullable();
            $table->string('national_id', 100)->nullable()->unique();

            $table->string('job_title');
            $table->string('directorate')->nullable();
            $table->string('department')->nullable();
            $table->string('official_position')->nullable();

            $table->string('phone', 50);
            $table->string('alternate_phone', 50)->nullable();
            $table->string('email')->nullable();

            $table->string('photo_path')->nullable();
            $table->string('signature_path')->nullable();

            $table->date('appointment_date')->nullable();
            $table->date('valid_from');
            $table->date('valid_until');

            $table->string('status', 50)->default('pending');
            $table->text('remarks')->nullable();

            $table->unsignedBigInteger('created_by')->nullable()->index();
            $table->unsignedBigInteger('approved_by')->nullable()->index();
            $table->timestamp('approved_at')->nullable();

            $table->timestamps();

            $table->index('status');
            $table->index('valid_until');
            $table->index(['budget_entity_id', 'status']);
            $table->index(['introduction_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('focal_points');
    }
};
