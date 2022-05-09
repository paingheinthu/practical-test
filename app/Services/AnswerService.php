<?php

namespace App\Services;

use App\Models\Answer;
use App\Contracts\AnswerInterface;
use App\Models\Survey;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class AnswerService implements AnswerInterface
{
    public function __construct(protected Answer $answer)
    {
    }

    public function createAnswer(Survey $survey, Question $question, $authUserId, string $answer): ?Answer
    {
        return $this->answer
            ->create(
                [
                    'survey_id' => $survey->id,
                    'question_id' => $question->id,
                    'user_id' => $authUserId,
                    'answer' => $answer
                ]
            );
    }

    public function getUserAnswers(User $user): ?Collection
    {
        return $user->answers;
    }

    public function getSurveyAnswers(Survey $survey): ?Collection
    {
        return $survey->answers;
    }
}
