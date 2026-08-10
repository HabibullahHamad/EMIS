<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('focal_point_cards', function (Blueprint $table) {
            $table->id();

            /*
             * focal_points is created by this module, so this FK is safe.
             */
            $table->foreignId('focal_point_id')
                ->constrained('focal_points')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('card_number', 150)->unique();
            $table->uuid('verification_uuid')->unique();

            $table->string('fiscal_year', 20);
            $table->date('issue_date');
            $table->date('expiry_date');

            $table->string('card_status', 50)->default('draft');

            $table->timestamp('printed_at')->nullable();
            $table->unsignedBigInteger('printed_by')->nullable()->index();

            $table->timestamp('issued_at')->nullable();
            $table->unsignedBigInteger('issued_by')->nullable()->index();

            $table->string('received_by_name')->nullable();
            $table->date('received_at')->nullable();

            $table->string('receiver_signature_path')->nullable();
            $table->string('pdf_path')->nullable();

            $table->unsignedInteger('reprint_count')->default(0);
            $table->text('reprint_reason')->nullable();

            $table->timestamp('revoked_at')->nullable();
            $table->unsignedBigInteger('revoked_by')->nullable()->index();
            $table->text('revocation_reason')->nullable();

            $table->timestamps();

            $table->index('card_status');
            $table->index('fiscal_year');
            $table->index('expiry_date');
            $table->index(['focal_point_id', 'card_status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('focal_point_cards');
    }
};
