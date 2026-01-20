<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();

            // Core document info
            $table->string('title');
            $table->string('document_type');     // Form, Report, Letter
            $table->string('module');            // EMIS Module name
            $table->string('reference_no')->nullable();

            // Workflow & status
            $table->string('status');            // Draft, Submitted, Approved, Rejected
            $table->string('approval_level')->nullable();

            // Organizational info
            $table->string('directorate');
            $table->string('department')->nullable();

            // Security & control
            $table->string('confidentiality_level')->default('Internal');

            // User tracking (audit)
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('approved_by')->nullable();

            $table->timestamps();

            // Optional FK constraints (recommended)
            // $table->foreign('created_by')->references('id')->on('users');
            // $table->foreign('approved_by')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
