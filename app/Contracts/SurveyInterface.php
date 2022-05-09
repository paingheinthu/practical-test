<?php

namespace App\Contracts;

use App\Models\Survey;
use App\Models\Question;
use Illuminate\Database\Eloquent\Collection;

interface SurveyInterface
{
    public function createSurvey(string $title, string $description = ""): ?Survey;

    public function getSurvey(string|int $filter): ?Survey;

    public function getSurveyQuestions(int $surveyId): ?Survey;

    public function disableSurvey(Survey $survey): bool;

    public function getActiveSurvey(): ?Collection;

    public function attachQuestion(Survey $survey, Question $question): ?Collection;
}
