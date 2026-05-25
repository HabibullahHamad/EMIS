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
    Schema::table('outgoingd', function (Blueprint $table) {
        $table->json('attachment_names')->nullable()->after('attachment');
    });
}

public function down(): void
{
    Schema::table('outgoingd', function (Blueprint $table) {
        $table->dropColumn('attachment_names');
    });
}

    /**
     * Reverse the migrations.
     */
  
};
