<?php

namespace App\Http\Controllers\Survey;

use Illuminate\Http\Request;
use App\Contracts\SurveyInterface;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SurveyController extends Controller
{
    public function __construct(protected SurveyInterface $surveyService)
    {
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                "title" => 'required'
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

        if ($survey = $this->surveyService->createSurvey($request->title, $request->get('description') ?: '')) {
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
        if ($survey = $this->surveyService->getSurveyQuestions($id)) {
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
        if ($survey = $this->surveyService->getSurvey($id)) {
            if ($survey->status == false) {
                return response()->json(
                    [
                        'message' => 'already disable your survey'
                    ],
                );
            }

            $res = $this->surveyService->disableSurvey($survey);
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
}
