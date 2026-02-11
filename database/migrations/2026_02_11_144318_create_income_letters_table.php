<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * use Illuminate\Database\Migrations\Migration;

         

     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('income_letters', function (Blueprint $table) {
           
               $table->id(); // id
            $table->string('letter_no'); // د لیک نمبر
            $table->string('sender'); // د لیک استوونکی
            $table->string('subject'); // د لیک موضوع
            $table->date('received_date'); // د رسیدو نیټه
            $table->text('description'); // د لیک بشپړ متن
            $table->timestamps(); // created_at, updated_at
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('income_letters');
    }
};
