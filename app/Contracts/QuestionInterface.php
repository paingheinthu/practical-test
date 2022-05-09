<?php

namespace App\Contracts;

use App\Models\Survey;
use App\Models\Question;

interface QuestionInterface
{
    public function createQuestion(string $title, string $type, bool $isRequire = false): ?Question;

    public function getQuestion(string|int $filter): ?Question;
}
