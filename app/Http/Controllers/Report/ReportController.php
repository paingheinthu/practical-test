<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Services\SurveyService;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function __construct(protected SurveyService $survey)
    {
    }

    public function reportSurveySummary(int $surveyId, Request $request)
    {
        $data = $this->survey->getSurveyAnswerReport($surveyId, $request->get('limit') ?: 10);
        return response()->json(
            [
                'data' => $data->count() > 0 ? $data : []
            ],
            $data->count() > 0 ? 200 : 404
        );
    }

    public function reportUserSummary(int $userId, Request $request)
    {
        $data = $this->survey->getUserAllSubmitted($userId, $request->get('limit') ?: 10);
        return response()->json(
            [
                'data' => $data->count() > 0 ? $data : []
            ],
            $data->count() > 0 ? 200 : 404
        );
    }
}
