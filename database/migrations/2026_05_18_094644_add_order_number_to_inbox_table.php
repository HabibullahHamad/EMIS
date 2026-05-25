<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inbox', function (Blueprint $table) {

            if (!Schema::hasColumn('inbox','order_number')) {

                $table->string('order_number')
                    ->nullable()
                    ->after('letter_no');

            }

        });
    }

    public function down(): void
    {
        Schema::table('inbox', function (Blueprint $table) {

            $table->dropColumn('order_number');

        });
    }
};