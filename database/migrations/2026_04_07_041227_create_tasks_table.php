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
    Schema::create('tasks', function (Blueprint $table) {
        $table->id();

        $table->string('task_code')->unique();
        $table->string('title');
        $table->text('description')->nullable();

        $table->foreignId('employee_id')->nullable()->constrained('employees')->nullOnDelete();

        $table->string('source_type')->nullable();
        $table->string('source_reference')->nullable();

        $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
        $table->enum('status', ['new', 'assigned', 'in_progress', 'completed', 'overdue', 'cancelled'])->default('new');

        $table->date('deadline')->nullable();
        $table->unsignedBigInteger('assigned_by')->nullable();
        $table->text('remarks')->nullable();

        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
