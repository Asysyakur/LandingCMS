<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use App\Models\PageVisit;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AnalyticsController extends Controller
{
    /**
     * Track visitor and page visit
     */
    public function trackVisitor(Request $request, $pageSlug)
    {
        // Get visitor ID from cookie or create new
        $visitorId = $request->cookie('visitor_id');
        
        if (!$visitorId) {
            $visitor = Visitor::create([
                'id' => Str::uuid(),
                'first_seen_at' => now(),
                'last_seen_at' => now()
            ]);
            $visitorId = $visitor->id;
        } else {
            $visitor = Visitor::find($visitorId);
            if ($visitor) {
                $visitor->update(['last_seen_at' => now()]);
            }
        }

        // Find page by slug
        $page = Page::where('slug', $pageSlug)->where('status', 'published')->first();
        
        if (!$page) {
            return response()->json([
                'status' => false,
                'message' => 'Page not found'
            ], 404);
        }

        // Check if this is a new visit (not visited in last 30 minutes)
        $isNewVisit = !PageVisit::where('visitor_id', $visitorId)
            ->where('page_id', $page->id)
            ->where('visited_at', '>', now()->subMinutes(30))
            ->exists();

        if ($isNewVisit) {
            PageVisit::create([
                'id' => Str::uuid(),
                'visitor_id' => $visitorId,
                'page_id' => $page->id,
                'visited_at' => now()
            ]);
        }

        return response()->json([
            'status' => true,
            'data' => [
                'is_new_visit' => $isNewVisit,
                'visitor_id' => $visitorId
            ]
        ])->cookie('visitor_id', $visitorId, 525600); // 1 year
    }

    /**
     * Get analytics data for user's pages
     */
    public function getAnalytics(Request $request)
    {
        $user = $request->user();
        
        // Get date range from request or default to last 30 days
        $startDate = $request->get('start_date', now()->subDays(30)->toDateString());
        $endDate = $request->get('end_date', now()->toDateString());

        // Get user's pages
        $pages = Page::where('created_by', $user->id)
            ->where('status', 'published')
            ->pluck('id');

        if ($pages->isEmpty()) {
            return response()->json([
                'status' => true,
                'data' => [
                    'user_id' => $user->id,
                    'period' => [
                        'start_date' => $startDate,
                        'end_date' => $endDate
                    ],
                    'summary' => [
                        'total_visitors' => 0,
                        'unique_visitors' => 0,
                        'bounce_rate' => 0
                    ],
                    'visitors_chart' => [],
                    'pages_breakdown' => []
                ]
            ]);
        }

        // Total visits
        $totalVisits = PageVisit::whereIn('page_id', $pages)
            ->whereBetween('visited_at', [$startDate, $endDate . ' 23:59:59'])
            ->count();

        // Unique visitors
        $uniqueVisitors = PageVisit::whereIn('page_id', $pages)
            ->whereBetween('visited_at', [$startDate, $endDate . ' 23:59:59'])
            ->distinct('visitor_id')
            ->count('visitor_id');

        // Calculate bounce rate (visitors with only 1 page view)
        $singlePageVisitors = DB::table('page_visits')
            ->select('visitor_id')
            ->whereIn('page_id', $pages)
            ->whereBetween('visited_at', [$startDate, $endDate . ' 23:59:59'])
            ->groupBy('visitor_id')
            ->havingRaw('COUNT(*) = 1')
            ->count();
            
        $bounceRate = $uniqueVisitors > 0 ? round(($singlePageVisitors / $uniqueVisitors) * 100, 2) : 0;

        // Daily visitors chart
        $visitorsChart = PageVisit::whereIn('page_id', $pages)
            ->whereBetween('visited_at', [$startDate, $endDate . ' 23:59:59'])
            ->selectRaw('DATE(visited_at) as date, COUNT(*) as visitors')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Pages breakdown
        $pagesBreakdown = Page::whereIn('id', $pages)
            ->withCount(['pageVisits' => function($query) use ($startDate, $endDate) {
                $query->whereBetween('visited_at', [$startDate, $endDate . ' 23:59:59']);
            }])
            ->orderBy('page_visits_count', 'desc')
            ->get()
            ->map(function ($page) {
                return [
                    'page_id' => $page->id,
                    'page_title' => $page->title,
                    'page_slug' => $page->slug,
                    'visits' => $page->page_visits_count
                ];
            });

        return response()->json([
            'status' => true,
            'data' => [
                'user_id' => $user->id,
                'period' => [
                    'start_date' => $startDate,
                    'end_date' => $endDate
                ],
                'summary' => [
                    'total_visitors' => $totalVisits,
                    'unique_visitors' => $uniqueVisitors,
                    'bounce_rate' => $bounceRate
                ],
                'visitors_chart' => $visitorsChart,
                'pages_breakdown' => $pagesBreakdown
            ]
        ]);
    }

    /**
     * Get detailed analytics for specific page
     */
    public function getPageAnalytics(Request $request, $pageId)
    {
        $page = Page::where('created_by', $request->user()->id)
            ->where('id', $pageId)
            ->firstOrFail();

        $startDate = $request->get('start_date', now()->subDays(30)->toDateString());
        $endDate = $request->get('end_date', now()->toDateString());

        // Daily visits for this page
        $dailyVisits = PageVisit::where('page_id', $pageId)
            ->whereBetween('visited_at', [$startDate, $endDate . ' 23:59:59'])
            ->selectRaw('DATE(visited_at) as date, COUNT(*) as visits')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Unique visitors for this page
        $uniqueVisitors = PageVisit::where('page_id', $pageId)
            ->whereBetween('visited_at', [$startDate, $endDate . ' 23:59:59'])
            ->distinct('visitor_id')
            ->count('visitor_id');

        // First time vs returning visitors
        $visitorStats = DB::table('visitors as v')
            ->join('page_visits as pv', 'v.id', '=', 'pv.visitor_id')
            ->where('pv.page_id', $pageId)
            ->whereBetween('pv.visited_at', [$startDate, $endDate . ' 23:59:59'])
            ->selectRaw('
                COUNT(CASE WHEN v.first_seen_at = pv.visited_at THEN 1 END) as first_time_visitors,
                COUNT(CASE WHEN v.first_seen_at != pv.visited_at THEN 1 END) as returning_visitors
            ')
            ->first();

        return response()->json([
            'status' => true,
            'data' => [
                'page' => [
                    'id' => $page->id,
                    'title' => $page->title,
                    'slug' => $page->slug
                ],
                'period' => [
                    'start_date' => $startDate,
                    'end_date' => $endDate
                ],
                'total_visits' => $dailyVisits->sum('visits'),
                'unique_visitors' => $uniqueVisitors,
                'first_time_visitors' => $visitorStats->first_time_visitors,
                'returning_visitors' => $visitorStats->returning_visitors,
                'daily_visits' => $dailyVisits
            ]
        ]);
    }
}
