<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
Schema::create('tasks', function (Blueprint $table) {
    $table->id();
    $table->string('task_code')->unique();
    $table->string('title');
    $table->text('description')->nullable();

    $table->foreignId('assigned_to')->constrained('users');
    $table->foreignId('assigned_by')->constrained('users');

    $table->enum('priority', ['Low','Medium','High'])->default('Medium');
    $table->enum('status', ['Assigned','In Progress','Completed','Cancelled'])->default('Assigned');

    $table->date('due_date')->nullable();
    $table->timestamps();
});

