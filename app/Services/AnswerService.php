<?php

namespace App\Services;

use App\Models\Answer;
use App\Models\Survey;
use App\Models\Question;
use App\Contracts\AnswerInterface;

class AnswerService implements AnswerInterface
{
    public function __construct(
        protected Answer $answer
    ) {
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

    public function checkAnswer(int $userId, int $surveyId, int $questionId): ?Answer
    {
        return $this->answer
            ->where('user_id', $userId)
            ->where('survey_id', $surveyId)
            ->where('question_id', $questionId)
            ->first();
    }
}
