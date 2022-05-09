<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->create('survey_questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('survey_id');
            $table->bigInteger('question_id');
            $table->timestamps();
            $table->unique(['survey_id', 'question_id'], 'survey_question_uniq');
            $table->index('survey_id');
            $table->index('question_id');
            $table->index(['survey_id', 'question_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survey_questions');
    }
};
