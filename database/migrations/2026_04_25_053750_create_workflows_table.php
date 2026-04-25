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
    Schema::create('workflows', function (Blueprint $table) {
        $table->id();

        $table->string('reference_type')->nullable(); // outbox, inbox, task
        $table->unsignedBigInteger('reference_id')->nullable();

        $table->string('title');
        $table->text('description')->nullable();

        $table->foreignId('from_user_id')->nullable()->constrained('users')->nullOnDelete();
        $table->foreignId('to_user_id')->nullable()->constrained('users')->nullOnDelete();

        $table->foreignId('from_department_id')->nullable()->constrained('departments')->nullOnDelete();
        $table->foreignId('to_department_id')->nullable()->constrained('departments')->nullOnDelete();

        $table->enum('priority', ['low', 'normal', 'high', 'urgent'])->default('normal');
        $table->enum('status', ['pending', 'forwarded', 'approved', 'rejected', 'returned', 'completed'])->default('pending');

        $table->text('remarks')->nullable();
        $table->timestamp('acted_at')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workflows');
    }
};
