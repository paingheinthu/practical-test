<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\Survey;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SurveySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Survey::factory(10)->create();
        Question::factory(3)->create();

        $questions = Question::all();

        Survey::all()->each(function ($survey) use ($questions) {
            $survey->questions()->saveMany($questions);
        });
    }
}
