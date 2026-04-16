<?php

// database/migrations/xxxx_xx_xx_create_documents_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('document_no')->unique();
            $table->string('subject');
            $table->string('sender');
            $table->string('receiver');
            $table->enum('type', ['Incoming', 'Outgoing']);
            $table->enum('status', ['Pending', 'In Progress', 'Completed', 'Archived'])->default('Pending');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->date('deadline')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
