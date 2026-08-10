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
    if (!Schema::hasTable('users')) {
        return;
    }

    $columns = array_values(array_filter(
        [
            'failed_login_attempts',
            'is_blocked',
            'blocked_at',
        ],
        fn (string $column): bool =>
            Schema::hasColumn('users', $column)
    ));

    if ($columns === []) {
        return;
    }

    Schema::table('users', function (Blueprint $table) use ($columns): void {
        $table->dropColumn($columns);
    });
}

    /**
     * Reverse the migrations.
     */
  
};
