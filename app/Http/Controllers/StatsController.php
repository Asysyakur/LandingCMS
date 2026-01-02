<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
   public function daily($businessId, Request $request)
{
    $request->validate([
        'start_date' => 'required|date',
        'end_date'   => 'required|date',
    ]);

    // 1️⃣ Ambil semua page milik business ini
    $pageIds = DB::table('pages')
        ->where('id', $businessId)
        ->orWhere('slug', $businessId)
        ->pluck('id');

    // 2️⃣ Hitung statistik kunjungan per hari
    $stats = DB::table('page_visits')
        ->selectRaw("
            DATE(visited_at) as date,
            COUNT(*) as total_pageviews,
            COUNT(DISTINCT visitor_id) as unique_visitors
        ")
        ->whereIn('page_id', $pageIds)
        ->whereDate('visited_at', '>=', $request->start_date)
        ->whereDate('visited_at', '<=', $request->end_date)
        ->groupBy(DB::raw('DATE(visited_at)'))
        ->orderBy('date')
        ->get();

    // 3️⃣ Format hasilnya
    $data = $stats->map(function ($row) {
        return [
            'date' => $row->date,
            'total_visitors' => (int) $row->unique_visitors,
            'total_pageviews' => (int) $row->total_pageviews,
            'unique_visitors' => (int) $row->unique_visitors,
        ];
    });

    return response()->json([
        'status' => true,
        'data'   => $data,
    ]);
}

}
