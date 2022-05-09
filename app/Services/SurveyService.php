<?php

namespace App\Services;

use App\Models\Survey;
use App\Contracts\SurveyInterface;
use Illuminate\Database\Eloquent\Collection;

class SurveyService implements SurveyInterface
{
    public function __construct(protected Survey $survey)
    {
    }

    public function createSurvey(string $title, string $description = ""): ?Survey
    {
        return $this->survey->create(
            [
                'title' => $title,
                'description' => $description
            ]
        );
    }

    public function getSurvey(string|int $filter): ?Survey
    {
        return $this->survey
            ->where(is_int($filter) ? 'id' : 'title', $filter)
            ->first();
    }

    public function disableSurvey(Survey $survey): bool
    {
        return $survey->update([
            'status' => 0,
        ]);
    }

    public function getActiveSurvey(): ?Collection
    {
        return $this->survey
            ->active()
            ->get();
    }
}
