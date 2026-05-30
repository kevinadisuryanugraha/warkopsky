<?php

namespace App\Services;

use App\Models\PageView;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AnalyticsService
{
    /**
     * Get overview KPI stats for the dashboard.
     */
    public function getOverviewStats(int $days = 30): array
    {
        $from = Carbon::now()->subDays($days)->startOfDay();
        $now  = Carbon::now();

        $totalViews = PageView::where('visited_at', '>=', $from)->count();
        $uniqueVisitors = PageView::where('visited_at', '>=', $from)
            ->distinct('session_id')
            ->count('session_id');

        $avgPerDay = $days > 0 ? round($totalViews / $days, 1) : $totalViews;

        // Calculate average session duration for multi-page sessions
        $views = PageView::where('visited_at', '>=', $from)
            ->orderBy('visited_at', 'asc')
            ->get();
        
        $sessions = [];
        foreach ($views as $view) {
            $sid = $view->session_id;
            if (!isset($sessions[$sid])) {
                $sessions[$sid] = [
                    'first' => $view->visited_at,
                    'last' => $view->visited_at,
                    'count' => 0
                ];
            }
            $sessions[$sid]['last'] = $view->visited_at;
            $sessions[$sid]['count']++;
        }

        $totalDuration = 0;
        $multiPageCount = 0;
        foreach ($sessions as $session) {
            if ($session['count'] > 1) {
                $totalDuration += abs($session['last']->diffInSeconds($session['first']));
                $multiPageCount++;
            }
        }

        $avgDurationSeconds = $multiPageCount > 0 ? round($totalDuration / $multiPageCount) : 0;
        
        $formattedAvgDuration = '00m 00s';
        if ($avgDurationSeconds > 0) {
            $mins = floor($avgDurationSeconds / 60);
            $secs = $avgDurationSeconds % 60;
            $formattedAvgDuration = sprintf('%02dm %02ds', $mins, $secs);
        }

        // Calculate dynamic conversion stats
        $mapsClicks = PageView::where('page_name', 'Klik Maps')->where('visited_at', '>=', $from)->count();
        $reservationsCount = \App\Models\Reservation::where('created_at', '>=', $from)->count();
        $conversionRate = $uniqueVisitors > 0 ? round(($reservationsCount / $uniqueVisitors) * 100, 1) : 0.0;

        // Funnel Step 2: Unique visitors who opened Menu or Kontak
        $funnelStep2 = PageView::whereIn('page_name', ['Menu', 'Kontak'])
            ->where('visited_at', '>=', $from)
            ->distinct('session_id')
            ->count('session_id');
        $funnelStep2Pct = $uniqueVisitors > 0 ? round(($funnelStep2 / $uniqueVisitors) * 100) : 0;

        // Funnel Step 3: Reservations
        $funnelStep3 = $reservationsCount;
        $funnelStep3Pct = $uniqueVisitors > 0 ? round(($funnelStep3 / $uniqueVisitors) * 100, 1) : 0.0;

        // Demographics simulation (Male/Female, Age, Dominant range)
        if ($uniqueVisitors === 0) {
            $genderMalePct = 0;
            $genderFemalePct = 0;
            $dominantAge = 'N/A';
            $ageDistribution = [0, 0, 0, 0, 0];
        } else {
            $genderMalePct = 33;
            $genderFemalePct = 67;
            $dominantAge = '55+';
            $ageDistribution = [
                (int) round($uniqueVisitors * 0.20),
                (int) round($uniqueVisitors * 0.20),
                (int) round($uniqueVisitors * 0.20),
                (int) round($uniqueVisitors * 0.16),
                (int) round($uniqueVisitors * 0.24)
            ];
        }

        // Calculate percentage change vs previous period
        $prevFrom = Carbon::now()->subDays($days * 2)->startOfDay();
        $prevTo   = $from;

        $prevViews = PageView::whereBetween('visited_at', [$prevFrom, $prevTo])->count();
        $prevUnique = PageView::whereBetween('visited_at', [$prevFrom, $prevTo])
            ->distinct('session_id')
            ->count('session_id');

        $viewsChange = $prevViews > 0
            ? round((($totalViews - $prevViews) / $prevViews) * 100, 1)
            : ($totalViews > 0 ? 100 : 0);

        $uniqueChange = $prevUnique > 0
            ? round((($uniqueVisitors - $prevUnique) / $prevUnique) * 100, 1)
            : ($uniqueVisitors > 0 ? 100 : 0);

        return [
            'total_views'     => $totalViews,
            'unique_visitors' => $uniqueVisitors,
            'avg_per_day'     => $avgPerDay,
            'views_change'    => $viewsChange,
            'unique_change'   => $uniqueChange,
            'avg_duration'    => $formattedAvgDuration,
            'maps_clicks'     => $mapsClicks,
            'reservations_count' => $reservationsCount,
            'conversion_rate' => $conversionRate,
            'funnel_step2'    => $funnelStep2,
            'funnel_step2_pct' => $funnelStep2Pct,
            'funnel_step3'    => $funnelStep3,
            'funnel_step3_pct' => $funnelStep3Pct,
            'gender_male_pct' => $genderMalePct,
            'gender_female_pct' => $genderFemalePct,
            'dominant_age'    => $dominantAge,
            'age_distribution' => $ageDistribution,
        ];
    }

    /**
     * Get views grouped by day for line chart.
     */
    public function getViewsByDay(int $days = 30): array
    {
        $from = Carbon::now()->subDays($days)->startOfDay();

        $results = PageView::where('visited_at', '>=', $from)
            ->select(
                DB::raw('DATE(visited_at) as date'),
                DB::raw('COUNT(*) as views'),
                DB::raw('COUNT(DISTINCT session_id) as unique_visitors')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Fill in missing dates with zero values
        $labels = [];
        $views  = [];
        $uniques = [];

        $current = $from->copy();
        $end = Carbon::now();

        // Create a lookup map
        $dataMap = [];
        foreach ($results as $row) {
            $dataMap[$row->date] = [
                'views'   => $row->views,
                'uniques' => $row->unique_visitors,
            ];
        }

        while ($current <= $end) {
            $dateKey = $current->format('Y-m-d');
            $labels[] = $current->format('d M');
            $views[]  = $dataMap[$dateKey]['views'] ?? 0;
            $uniques[] = $dataMap[$dateKey]['uniques'] ?? 0;
            $current->addDay();
        }

        return [
            'labels'  => $labels,
            'views'   => $views,
            'uniques' => $uniques,
        ];
    }

    /**
     * Get top visited pages.
     */
    public function getTopPages(int $limit = 10, int $days = 30): array
    {
        $from = Carbon::now()->subDays($days)->startOfDay();

        return PageView::where('visited_at', '>=', $from)
            ->select(
                'page_name',
                DB::raw('COUNT(*) as views'),
                DB::raw('COUNT(DISTINCT session_id) as unique_visitors')
            )
            ->groupBy('page_name')
            ->orderByDesc('views')
            ->limit($limit)
            ->get()
            ->toArray();
    }

    /**
     * Get browser breakdown for doughnut chart.
     */
    public function getBrowserStats(int $days = 30): array
    {
        $from = Carbon::now()->subDays($days)->startOfDay();

        $results = PageView::where('visited_at', '>=', $from)
            ->select('browser', DB::raw('COUNT(*) as total'))
            ->whereNotNull('browser')
            ->groupBy('browser')
            ->orderByDesc('total')
            ->limit(6)
            ->get();

        return [
            'labels' => $results->pluck('browser')->toArray(),
            'data'   => $results->pluck('total')->toArray(),
        ];
    }

    /**
     * Get device type breakdown for doughnut chart.
     */
    public function getDeviceStats(int $days = 30): array
    {
        $from = Carbon::now()->subDays($days)->startOfDay();

        $results = PageView::where('visited_at', '>=', $from)
            ->select('device_type', DB::raw('COUNT(*) as total'))
            ->whereNotNull('device_type')
            ->groupBy('device_type')
            ->orderByDesc('total')
            ->get();

        // Capitalize labels for display
        $labelMap = [
            'desktop' => 'Desktop',
            'mobile'  => 'Mobile',
            'tablet'  => 'Tablet',
        ];

        return [
            'labels' => $results->pluck('device_type')->map(fn($d) => $labelMap[$d] ?? ucfirst($d))->toArray(),
            'data'   => $results->pluck('total')->toArray(),
        ];
    }

    /**
     * Get platform/OS breakdown.
     */
    public function getPlatformStats(int $days = 30): array
    {
        $from = Carbon::now()->subDays($days)->startOfDay();

        $results = PageView::where('visited_at', '>=', $from)
            ->select('platform', DB::raw('COUNT(*) as total'))
            ->whereNotNull('platform')
            ->groupBy('platform')
            ->orderByDesc('total')
            ->limit(6)
            ->get();

        return [
            'labels' => $results->pluck('platform')->toArray(),
            'data'   => $results->pluck('total')->toArray(),
        ];
    }

    /**
     * Get top referring sources.
     */
    public function getTopReferers(int $limit = 10, int $days = 30): array
    {
        $from = Carbon::now()->subDays($days)->startOfDay();

        return PageView::where('visited_at', '>=', $from)
            ->whereNotNull('referer')
            ->where('referer', '!=', '')
            ->select(
                DB::raw("CASE 
                    WHEN referer LIKE '%google%' THEN 'Google Search'
                    WHEN referer LIKE '%bing%' THEN 'Bing Search'
                    WHEN referer LIKE '%yahoo%' THEN 'Yahoo Search'
                    WHEN referer LIKE '%instagram%' THEN 'Instagram'
                    WHEN referer LIKE '%facebook%' THEN 'Facebook'
                    WHEN referer LIKE '%twitter%' THEN 'Twitter/X'
                    WHEN referer LIKE '%tiktok%' THEN 'TikTok'
                    WHEN referer LIKE '%youtube%' THEN 'YouTube'
                    WHEN referer LIKE '%whatsapp%' THEN 'WhatsApp'
                    WHEN referer LIKE '%t.co%' THEN 'Twitter/X'
                    ELSE SUBSTRING_INDEX(SUBSTRING_INDEX(REPLACE(REPLACE(referer, 'https://', ''), 'http://', ''), '/', 1), '?', 1)
                END as source"),
                DB::raw('COUNT(*) as visits')
            )
            ->groupBy('source')
            ->orderByDesc('visits')
            ->limit($limit)
            ->get()
            ->toArray();
    }

    /**
     * Get hourly visit distribution (0-23).
     */
    public function getHourlyDistribution(int $days = 30): array
    {
        $from = Carbon::now()->subDays($days)->startOfDay();

        $results = PageView::where('visited_at', '>=', $from)
            ->select(
                DB::raw('HOUR(visited_at) as hour'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('hour')
            ->orderBy('hour')
            ->get()
            ->keyBy('hour');

        $labels = [];
        $data   = [];

        for ($h = 0; $h < 24; $h++) {
            $labels[] = str_pad($h, 2, '0', STR_PAD_LEFT) . ':00';
            $data[]   = $results->has($h) ? $results[$h]->total : 0;
        }

        return [
            'labels' => $labels,
            'data'   => $data,
        ];
    }

    /**
     * Get real-time visitors (unique sessions in last N minutes).
     */
    public function getRealtimeVisitors(int $minutes = 15): int
    {
        return PageView::where('visited_at', '>=', Carbon::now()->subMinutes($minutes))
            ->distinct('session_id')
            ->count('session_id');
    }

    /**
     * Get top locations breakdown.
     */
    public function getLocationStats(int $days = 30, int $limit = 5): array
    {
        $from = Carbon::now()->subDays($days)->startOfDay();

        $results = PageView::where('visited_at', '>=', $from)
            ->whereNotNull('country')
            ->where('country', '!=', '')
            ->select('country', DB::raw('COUNT(*) as total'))
            ->groupBy('country')
            ->orderByDesc('total')
            ->limit($limit)
            ->get();

        $totalViews = PageView::where('visited_at', '>=', $from)->count();

        $data = [];
        foreach ($results as $row) {
            $parts = explode(', ', $row->country);
            $cleanLoc = $row->country;
            if (count($parts) >= 3) {
                $city = $parts[0];
                $country = explode(' (', $parts[2])[0];
                // abbreviate Indonesia to ID, Poland to PL, etc.
                if ($country === 'Indonesia') $country = 'ID';
                $cleanLoc = "$city, $country";
            } elseif ($row->country === 'Localhost (Bekasi, Indonesia)') {
                $cleanLoc = 'Bekasi, ID';
            } elseif ($row->country === 'Unknown Location') {
                $cleanLoc = 'Unknown';
            }

            $pct = $totalViews > 0 ? round(($row->total / $totalViews) * 100, 1) : 0;
            $data[] = [
                'location' => $cleanLoc,
                'visits' => $row->total,
                'percentage' => $pct,
            ];
        }

        return $data;
    }

    /**
     * Get detailed visitor logs grouped by session, with clickstreams and duration.
     */
    public function getVisitorSessions(int $days = 30): array
    {
        $from = Carbon::now()->subDays($days)->startOfDay();

        // Get all page views in the given range, ordered chronologically
        $views = PageView::where('visited_at', '>=', $from)
            ->orderBy('visited_at', 'asc')
            ->get();

        $sessions = [];

        foreach ($views as $view) {
            $sid = $view->session_id;

            if (!isset($sessions[$sid])) {
                $sessions[$sid] = [
                    'session_id'     => $sid,
                    'ip_address'     => $view->ip_address,
                    'location'       => $view->country ?? 'Unknown Location',
                    'browser'        => $view->browser ?? 'Other',
                    'platform'       => $view->platform ?? 'Other',
                    'device_type'    => $view->device_type ?? 'desktop',
                    'referer'        => $view->referer ?: 'Direct',
                    'first_visit'    => $view->visited_at,
                    'last_visit'     => $view->visited_at,
                    'page_views'     => 0,
                    'clickstream'    => [],
                ];
            }

            $sessions[$sid]['page_views']++;
            $sessions[$sid]['last_visit'] = $view->visited_at;

            // Build chronological clickstream flow
            $sessions[$sid]['clickstream'][] = [
                'page_name'  => $view->page_name ?? 'Page',
                'url'        => $view->url,
                'time'       => $view->visited_at->format('H:i:s'),
            ];
        }

        // Calculate session durations and format output
        foreach ($sessions as &$session) {
            $first = $session['first_visit'];
            $last  = $session['last_visit'];
            $durationInSeconds = abs($last->diffInSeconds($first));

            if ($durationInSeconds === 0) {
                $session['duration'] = 'Single page hit';
            } elseif ($durationInSeconds < 60) {
                $session['duration'] = $durationInSeconds . ' detik';
            } else {
                $mins = floor($durationInSeconds / 60);
                $secs = $durationInSeconds % 60;
                $session['duration'] = $mins . ' m ' . $secs . ' s';
            }
        }

        // Sort sessions by latest activity (last_visit desc)
        usort($sessions, function($a, $b) {
            return $b['last_visit'] <=> $a['last_visit'];
        });

        return $sessions;
    }
}
