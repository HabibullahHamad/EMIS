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
           
             $table->foreignId('income_letter_id')->constrained('income_letters')->onDelete('cascade'); // د لیک ID
            $table->string('title'); // د دندې عنوان
            $table->foreignId('assigned_to')->constrained('users')->onDelete('cascade'); // د څانګې یا کارونکي ID
            $table->enum('status', ['Pending', 'Completed'])->default('Pending'); // حالت
            $table->date('due_date'); // د دندې ختمیدو نیټه
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade'); // د دندې جوړوونکي کارونکی
            $table->timestamps(); // created_at, updated_at
           
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
