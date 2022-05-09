<?php

namespace App\Contracts;

use App\Models\Survey;

interface SurveyInterface
{
    public function createSurvey(string $title, string $description = ""): ?Survey;

    public function getSurvey(string|int $filter): ?Survey;

    public function disableSurvey(Survey $survey): bool;
}
