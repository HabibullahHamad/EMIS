<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inbox', function (Blueprint $table) {

            if (!Schema::hasColumn('inbox','attachment_names')) {

                $table->json('attachment_names')
                    ->nullable()
                    ->after('attachment');

            }

        });
    }

    public function down(): void
    {
        Schema::table('inbox', function (Blueprint $table) {

            $table->dropColumn('attachment_names');

        });
    }
};