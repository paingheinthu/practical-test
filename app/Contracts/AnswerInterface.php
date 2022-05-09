<?php

namespace App\Contracts;

use App\Models\User;
use App\Models\Answer;
use App\Models\Survey;
use App\Models\Question;

interface AnswerInterface
{
    public function createAnswer(Survey $survey, Question $question, int $authUserId, string $answer): ?Answer;

    public function checkAnswer(int $userId, int $surveyId, int $questionId): ?Answer;
}
