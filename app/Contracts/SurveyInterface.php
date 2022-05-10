<?php

namespace App\Contracts;

use App\Models\Survey;
use App\Models\Question;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface SurveyInterface
{
    public function createSurvey(string $title, string $description = ""): ?Survey;

    public function getSurvey(string|int $filter): ?Survey;

    public function getSurveyQuestions(int $surveyId): ?Survey;

    public function disableSurvey(Survey $survey): bool;

    public function getActiveSurvey(): ?Collection;

    public function attachQuestion(Survey $survey, Question $question): ?Collection;

    public function getSurveyAnswerReport(int $surveyId, int $limit = 10): ?LengthAwarePaginator;

    public function getUserAllSubmitted(int $userId, int $limit = 10): ?LengthAwarePaginator;
}
