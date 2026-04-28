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
    Schema::create('notifications', function (Blueprint $table) {
        $table->id();

        $table->foreignId('user_id')
            ->constrained('users')
            ->cascadeOnDelete();

        $table->string('title');
        $table->text('message')->nullable();

        $table->string('type')->default('general');
        // workflow, task, document, security, general

        $table->string('priority')->default('normal');
        // low, normal, high, urgent

        $table->string('related_type')->nullable();
        $table->unsignedBigInteger('related_id')->nullable();

        $table->boolean('is_read')->default(false);
        $table->timestamp('read_at')->nullable();

        $table->timestamps();

        $table->index(['user_id', 'is_read']);
        $table->index(['related_type', 'related_id']);
    });
}
};

