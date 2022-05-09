<?php

namespace App\Services;

use App\Models\Question;
use App\Contracts\QuestionInterface;

class QuestionService implements QuestionInterface
{
    public function __construct(protected Question $question)
    {
    }

    public function createQuestion(string $title, string $type, bool $isRequire = false): ?Question
    {
        return $this->question->create([
            'title' => $title,
            'type' => $type,
            'is_required' => $isRequire
        ]);
    }

    public function getQuestion(string|int $filter): ?Question
    {
        return $this->question
            ->where(is_int($filter) ? 'id' : 'title', $filter)
            ->first();
    }
}
