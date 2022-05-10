<?php

namespace App\Services;

use App\Models\Answer;
use App\Models\Survey;
use App\Models\Question;
use App\Contracts\SurveyInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SurveyService implements SurveyInterface
{
    public function __construct(
        protected Survey $survey,
        protected Answer $answer
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

    public function getSurveyAnswerReport(int $surveyId, int $limit = 10): ?LengthAwarePaginator
    {
        return $this->answer
            ->with(['question:id,title', 'survey:id,title'])
            ->where('survey_id', $surveyId)
            ->paginate($limit);
    }

    public function getUserAllSubmitted(int $userId, int $limit = 10): ?LengthAwarePaginator
    {
        return $this->answer
            ->with(['user:id,name', 'survey:id,title', 'question:id,title'])
            ->where('user_id', $userId)
            ->paginate($limit);
    }
}
