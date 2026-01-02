<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function analytics(Request $request)
    {
        return response()->json([
            "status" => true,
            "data" => [
                "user_id" => 6,

                "period" => [
                    "start_date" => "2025-01-01 09:00",
                    "end_date"   => "2025-01-07 23:59",
                ],

                "summary" => [
                    "total_visitors" => 3,
                    "unique_visitors" => 1,
                    "bounce_rate" => 66,
                ],

                "visitors_chart" => [
                    [
                        "date" => "2025-01-01",
                        "visitors" => 2,
                    ],
                    [
                        "date" => "2025-01-02",
                        "visitors" => 1,
                    ],
                ],
            ]
        ]);
    }
}
