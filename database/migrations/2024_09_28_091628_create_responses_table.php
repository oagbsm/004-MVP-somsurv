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
        Schema::create('responses', function (Blueprint $table) {
            $table->id(); // Unique identifier for each response
            $table->unsignedBigInteger('survey_id'); // References the survey
            $table->text('formatted_answers'); // Stores answers in a structured format
            $table->timestamps(); // created_at and updated_at timestamps
            $table->unsignedBigInteger('user_id'); // References the survey

            // Foreign key constraints
            // $table->foreign('survey_id')->references('id')->on('surveys')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_responses');
    }
};
