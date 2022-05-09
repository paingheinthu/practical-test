<?php

namespace App\Http\Controllers\Survey;

use Illuminate\Http\Request;
use App\Services\SurveyService;
use App\Services\QuestionService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SurveyController extends Controller
{
    public function __construct(
        protected SurveyService $survey,
        protected QuestionService $question
    ) {
    }

    public function index()
    {
        return response()->json(
            [
                'data' => $this->survey->getActiveSurvey()
            ]
        );
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'title' => 'required'
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'message' => $validator->errors(),
                ],
                422
            );
        }

        if ($survey = $this->survey->createSurvey($request->title, $request->get('description') ?: '')) {
            return response()->json(
                [
                    'data' => $survey
                ]
            );
        }

        return response()->json(
            [
                'message' => 'can not create survey'
            ],
            406
        );
    }

    public function show(int $id)
    {
        if ($survey = $this->survey->getSurveyQuestions($id)) {
            return response()->json(
                [
                    'data' => $survey
                ]
            );
        }

        return response()->json(
            [
                'message' => 'survey not found'
            ],
            404
        );
    }

    public function disable(int $id)
    {
        if ($survey = $this->survey->getSurvey($id)) {
            if ($survey->status == false) {
                return response()->json(
                    [
                        'message' => 'already disable your survey'
                    ],
                );
            }

            $res = $this->survey->disableSurvey($survey);
            return response()->json(
                [
                    'message' => $res ? 'successfully disable survey' : 'can not disable'
                ],
                $res ? 200 : 406
            );
        }

        return response()->json(
            [
                'message' => 'survey not found',
            ],
            404
        );
    }

    public function attachQuestion(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'survey_id' => 'required|int',
                'question_id' => 'required|int'
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

        $survey = $this->survey->getSurvey($request->survey_id);
        if (!$survey) {
            return response()->json(
                [
                    'message' => 'survey not found'
                ],
                404
            );
        }

        $question = $this->question->getQuestion($request->question_id);
        if (!$question) {
            return response()->json(
                [
                    'message' => 'question not found'
                ],
                404
            );
        }

        if ($attach = $this->survey->attachQuestion($survey, $question)) {
            return response()->json(
                [
                    'data' => $attach
                ]
            );
        }

        return response()->json(
            [
                'message' => 'can not attach the question to survey'
            ],
            406
        );
    }
}
