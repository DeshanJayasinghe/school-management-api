<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('student_class', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users');
            $table->foreignId('class_id')->constrained('classes');
            $table->timestamps();
            $table->unique(['student_id', 'class_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('student_class');
    }
};