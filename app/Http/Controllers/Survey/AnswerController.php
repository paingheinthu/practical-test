<?php

namespace App\Http\Controllers\Survey;

use Illuminate\Http\Request;
use App\Services\AnswerService;
use App\Services\SurveyService;
use App\Services\QuestionService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AnswerController extends Controller
{
    public function __construct(
        protected AnswerService $answer,
        protected SurveyService $survey,
        protected QuestionService $question
    ) {
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'survey_id' => 'required',
                'question_id' => 'required',
                'answer' => 'required'
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'message' => $validator->errors()
                ],
                422
            );
        }

        $survey = $this->survey->getSurveyQuestions($request->survey_id);
        if (!$survey) {
            return response()->json(
                [
                    'message' => 'survey not found'
                ],
                404
            );
        }

        $question = $survey->questions->firstWhere('id', $request->question_id);
        if (!$question) {
            return response()->json(
                [
                    'message' => 'question is not include in survey ' . $survey?->title,
                ],
                404
            );
        }

        if ($this->answer->checkAnswer(auth()->id(), $survey->id, $question->id)) {
            return response()->json(
                [
                    'message' => 'already submitted'
                ],
                406
            );
        }

        if ($answer = $this->answer->createAnswer($survey, $question, auth()->id(), $request->answer)) {
            return response()->json(
                [
                    'data' => $answer
                ]
            );
        }

        return response()->json(
            [
                'message' => 'can not create the answer'
            ],
            406
        );
    }
}
