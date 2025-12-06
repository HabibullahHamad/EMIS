<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inbox', function (Blueprint $table) {
            $table->id();
            $table->string('letter_no')->unique();             // د مکتوب نمبر
            $table->string('subject');                         // موضوع
            $table->string('sender');                          // صادر کوونکی
            $table->string('receiver')->nullable();            // ترلاسه کوونکی
            $table->date('received_date');                     // د ترلاسه کېدو نیټه
            $table->text('summary')->nullable();               // لنډ معلومات
            $table->string('attachment')->nullable();          // فایلونه
            $table->enum('priority', ['High', 'Medium', 'Low'])
                  ->default('Low');                           // لومړیتوب
            $table->enum('status', ['Unread', 'Read', 'Assigned', 'Completed'])
                  ->default('Unread');                         // حالت
            $table->unsignedBigInteger('assigned_to')->nullable(); // څوک ته ورکړل شوی
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inbox');
    }
};