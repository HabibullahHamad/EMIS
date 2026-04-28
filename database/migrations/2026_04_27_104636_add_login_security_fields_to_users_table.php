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
    Schema::table('users', function (Blueprint $table) {
        $table->integer('failed_login_attempts')->default(0);
        $table->boolean('is_blocked')->default(false);
        $table->timestamp('blocked_at')->nullable();
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn([
            'failed_login_attempts',
            'is_blocked',
            'blocked_at',
        ]);
    });
}

    /**
     * Reverse the migrations.
     */
  
};
