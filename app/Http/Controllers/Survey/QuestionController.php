<?php

namespace App\Http\Controllers\Survey;

use App\Constants\AllowTypes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\QuestionService;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
    public function __construct(protected QuestionService $question)
    {
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'title' => 'required',
                'type' => 'required'
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

        if (!in_array($request->type, AllowTypes::values())) {
            return response()->json(
                [
                    'message' => 'sorry, we are not allow this type'
                ],
                406
            );
        }

        if ($this->question->getQuestion($request->title)) {
            return response()->json(
                [
                    'message' => 'this question already created'
                ],
                406
            );
        }

        if ($question = $this->question->createQuestion($request->title, $request->type, $request->get('is_require') ?: false)) {
            return response()->json(
                [
                    'data' => $question
                ]
            );
        }

        return response()->json(
            [
                'message' => 'can not create question'
            ],
            406
        );
    }
}
