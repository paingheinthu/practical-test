<?php

namespace App\Services;

use App\Models\Survey;
use App\Models\Question;
use App\Contracts\SurveyInterface;
use Illuminate\Support\Facades\Log;
use App\Contracts\QuestionInterface;
use Illuminate\Database\Eloquent\Collection;

class SurveyService implements SurveyInterface
{
    public function __construct(
        protected Survey $survey
    ) {
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

    public function getSurveyQuestions(int $surveyId): ?Survey
    {
        return $this->survey
            ->where('id', $surveyId)
            ->with('questions')
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
            ->with('questions')
            ->get();
    }

    public function attachQuestion(Survey $survey, Question $question): ?Collection
    {
        try {
            $survey->questions()->attach($question);
            $survey->refresh();
            return $survey->questions;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return null;
        }

        return null;
    }
}
