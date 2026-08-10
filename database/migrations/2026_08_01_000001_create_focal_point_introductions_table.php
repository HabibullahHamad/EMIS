<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('focal_point_introductions', function (Blueprint $table) {
            $table->id();

            /*
             * Existing EMIS tables may use a different integer type.
             * Therefore external references are indexed without DB foreign keys.
             */
            $table->unsignedBigInteger('budget_entity_id')->index();
            $table->unsignedBigInteger('inbox_id')->nullable()->index();

            $table->string('letter_number', 150);
            $table->date('letter_date');
            $table->date('received_date');
            $table->string('subject');
            $table->unsignedInteger('number_of_nominees')->default(1);
            $table->string('attachment')->nullable();

            $table->string('status', 50)->default('received');

            $table->unsignedBigInteger('reviewed_by')->nullable()->index();
            $table->timestamp('reviewed_at')->nullable();
            $table->text('approval_notes')->nullable();

            $table->unsignedBigInteger('created_by')->nullable()->index();

            $table->timestamps();

            $table->index('letter_number');
            $table->index('status');
            $table->index(['budget_entity_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('focal_point_introductions');
    }
};
