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
        Schema::create('week_completions', function (Blueprint $table) {
            $table->id();
            $table->integer('lesson_count');
            $table->integer('lesson_completion_count')->default(0);
            $table->integer('student_id');
            $table->integer('course_id');
            $table->integer('batch_id');
            $table->integer('week_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('week_completions');
    }
};
