<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AnalyticsController extends Controller
{
    protected AnalyticsService $analytics;

    public function __construct(AnalyticsService $analytics)
    {
        $this->analytics = $analytics;
    }

    /**
     * Display the analytics dashboard page.
     */
    public function index()
    {
        $days = 30; // Default view

        $data = [
            'overview'    => $this->analytics->getOverviewStats($days),
            'viewsByDay'  => $this->analytics->getViewsByDay($days),
            'topPages'    => $this->analytics->getTopPages(10, $days),
            'browsers'    => $this->analytics->getBrowserStats($days),
            'devices'     => $this->analytics->getDeviceStats($days),
            'platforms'   => $this->analytics->getPlatformStats($days),
            'referers'    => $this->analytics->getTopReferers(10, $days),
            'hourly'      => $this->analytics->getHourlyDistribution($days),
            'realtime'    => $this->analytics->getRealtimeVisitors(15),
            'visitorSessions' => $this->analytics->getVisitorSessions($days),
            'locationStats' => $this->analytics->getLocationStats($days, 5),
            'activeDays'  => $days,
        ];

        return view('admin.analytics', $data);
    }

    /**
     * AJAX endpoint for date-range filtered chart data.
     */
    public function apiData(Request $request): JsonResponse
    {
        $days = (int) $request->query('days', 30);

        // Sanitize: clamp between 1 and 365
        $days = max(1, min(365, $days));

        return response()->json([
            'overview'    => $this->analytics->getOverviewStats($days),
            'viewsByDay'  => $this->analytics->getViewsByDay($days),
            'topPages'    => $this->analytics->getTopPages(10, $days),
            'browsers'    => $this->analytics->getBrowserStats($days),
            'devices'     => $this->analytics->getDeviceStats($days),
            'platforms'   => $this->analytics->getPlatformStats($days),
            'referers'    => $this->analytics->getTopReferers(10, $days),
            'hourly'      => $this->analytics->getHourlyDistribution($days),
            'realtime'    => $this->analytics->getRealtimeVisitors(15),
            'visitorSessions' => $this->analytics->getVisitorSessions($days),
            'locationStats' => $this->analytics->getLocationStats($days, 5),
            'activeDays'  => $days,
        ]);
    }

    /**
     * Reset all tracking telemetry (truncate PageViews).
     */
    public function reset(Request $request): JsonResponse
    {
        \App\Models\PageView::truncate();
        
        return response()->json([
            'success' => true,
            'message' => 'Semua data pelacakan berhasil direset.'
        ]);
    }
}
