<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
 public function up()
{
    Schema::create('documents', function (Blueprint $table) {
        $table->id();

        $table->string('document_number')->unique();

        $table->string('title');
        $table->text('subject')->nullable();
        $table->string('organization')->nullable();

        $table->enum('type', ['incoming','outgoing'])->default('incoming');

        $table->enum('status', [
            'registered',
            'assigned',
            'in_progress',
            'responded',
            'completed'
        ])->default('registered');

        $table->date('received_date')->nullable();
        $table->date('due_date')->nullable();
        $table->timestamp('completed_at')->nullable();

        $table->unsignedBigInteger('created_by')->nullable();
        $table->unsignedBigInteger('assigned_to')->nullable();

        $table->string('file_path')->nullable();

        $table->string('priority')->default('normal');
        $table->text('remarks')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
