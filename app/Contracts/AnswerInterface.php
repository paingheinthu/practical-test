<?php

namespace App\Contracts;

use App\Models\User;
use App\Models\Answer;
use App\Models\Survey;
use App\Models\Question;
use Illuminate\Database\Eloquent\Collection;

interface AnswerInterface
{
    public function createAnswer(Survey $survey, Question $question, int $authUserId, string $answer): ?Answer;

    public function getUserAnswers(User $user): ?Collection;

    public function getSurveyAnswers(Survey $survey): ?Collection;
}
