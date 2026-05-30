<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageView;
use Carbon\Carbon;
use Illuminate\Support\Str;

class PageViewSeeder extends Seeder
{
    /**
     * Seed the page_views table with realistic, chronological visitor telemetry.
     */
    public function run(): void
    {
        // Clear existing page views first to guarantee a clean, pristine seed
        PageView::truncate();

        // 1. Defined pool of typical visitors
        $visitorPool = [
            [
                'ip' => '182.3.45.107',
                'device' => 'desktop',
                'browser' => 'Chrome',
                'platform' => 'Windows 10+',
                'ua' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36',
                'location' => 'Jakarta, Special Capital Region of Jakarta, Indonesia (Telkom)',
                'referer' => 'Google Search',
            ],
            [
                'ip' => '114.122.14.88',
                'device' => 'mobile',
                'browser' => 'Safari',
                'platform' => 'iOS',
                'ua' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_4 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.4 Mobile/15E148 Safari/604.1',
                'location' => 'Depok, West Java, Indonesia (Indosat)',
                'referer' => 'Instagram',
            ],
            [
                'ip' => '83.144.119.5',
                'device' => 'desktop',
                'browser' => 'Firefox',
                'platform' => 'Linux',
                'ua' => 'Mozilla/5.0 (X11; Linux x86_64; rv:126.0) Gecko/20100101 Firefox/126.0',
                'location' => 'Warsaw, Masovian Voivodeship, Poland (Orange)',
                'referer' => 'Direct',
            ],
            [
                'ip' => '66.249.79.11',
                'device' => 'desktop',
                'browser' => 'Chrome',
                'platform' => 'Windows 10+',
                'ua' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36',
                'location' => 'Santa Clara, California, United States (Google)',
                'referer' => 'Google Search',
            ],
            [
                'ip' => '180.244.160.22',
                'device' => 'mobile',
                'browser' => 'Chrome',
                'platform' => 'Android',
                'ua' => 'Mozilla/5.0 (Linux; Android 14; SM-S911B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Mobile Safari/537.36',
                'location' => 'Cibinong, West Java, Indonesia (Link Net)',
                'referer' => 'TikTok',
            ],
            [
                'ip' => '103.156.12.18',
                'device' => 'tablet',
                'browser' => 'Safari',
                'platform' => 'iPadOS',
                'ua' => 'Mozilla/5.0 (iPad; CPU OS 17_4 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.4 Mobile/15E148 Safari/604.1',
                'location' => 'Bekasi, West Java, Indonesia (Biznet)',
                'referer' => 'Direct',
            ],
            [
                'ip' => '125.167.33.201',
                'device' => 'mobile',
                'browser' => 'Chrome',
                'platform' => 'Android',
                'ua' => 'Mozilla/5.0 (Linux; Android 13; SM-A536B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Mobile Safari/537.36',
                'location' => 'Jakarta, Special Capital Region of Jakarta, Indonesia (XL Axiata)',
                'referer' => 'WhatsApp',
            ],
        ];

        // 2. Defined sequential paths of visitor journeys (Clickstream Flows)
        $clickstreamPaths = [
            // Path A: Homepage only (Bounce)
            [
                ['path' => '/', 'name' => 'Homepage'],
            ],
            // Path B: Homepage -> Menu
            [
                ['path' => '/', 'name' => 'Homepage'],
                ['path' => '/menu', 'name' => 'Menu'],
            ],
            // Path C: Homepage -> Menu -> Kontak
            [
                ['path' => '/', 'name' => 'Homepage'],
                ['path' => '/menu', 'name' => 'Menu'],
                ['path' => '/kontak', 'name' => 'Kontak'],
            ],
            // Path D: Homepage -> Tentang -> Kontak
            [
                ['path' => '/', 'name' => 'Homepage'],
                ['path' => '/tentang', 'name' => 'Tentang Kami'],
                ['path' => '/kontak', 'name' => 'Kontak'],
            ],
            // Path E: Homepage -> Galeri -> Stories -> Kontak (High Engagement)
            [
                ['path' => '/', 'name' => 'Homepage'],
                ['path' => '/galeri', 'name' => 'Galeri'],
                ['path' => '/stories', 'name' => 'Stories'],
                ['path' => '/kontak', 'name' => 'Kontak'],
            ],
            // Path F: Direct to Menu (Search / Bookmark)
            [
                ['path' => '/menu', 'name' => 'Menu'],
                ['path' => '/kontak', 'name' => 'Kontak'],
            ],
            // Path G: Homepage -> Kontak -> Klik Maps
            [
                ['path' => '/', 'name' => 'Homepage'],
                ['path' => '/kontak', 'name' => 'Kontak'],
                ['path' => '/outbound/maps', 'name' => 'Klik Maps'],
            ],
            // Path H: Homepage -> Tentang -> Klik Maps
            [
                ['path' => '/', 'name' => 'Homepage'],
                ['path' => '/tentang', 'name' => 'Tentang Kami'],
                ['path' => '/outbound/maps', 'name' => 'Klik Maps'],
            ],
        ];

        $appUrl = rtrim(config('app.url'), '/');

        // Generate traffic for the last 30 days
        for ($day = 29; $day >= 0; $day--) {
            $currentDate = Carbon::now()->subDays($day);
            $dayOfWeek = $currentDate->dayOfWeek; // 0 (Sunday) to 6 (Saturday)

            // Determine volume: weekends have more traffic
            $isWeekend = ($dayOfWeek === Carbon::FRIDAY || $dayOfWeek === Carbon::SATURDAY || $dayOfWeek === Carbon::SUNDAY);
            $sessionsCount = $isWeekend ? rand(8, 15) : rand(3, 7);

            // Special: let's generate more traffic on the most recent days to make the charts spike beautifully
            if ($day <= 3) {
                $sessionsCount += rand(5, 10);
            }

            for ($s = 0; $s < $sessionsCount; $s++) {
                // Pick a random visitor profile
                $visitor = $visitorPool[array_rand($visitorPool)];
                
                // Pick a clickstream path
                $pathFlow = $clickstreamPaths[array_rand($clickstreamPaths)];

                $sessionId = Str::uuid()->toString();

                // Define session start time
                // Distribute visitors beautifully throughout coffee shop operating hours (mostly afternoon/evening)
                $hour = 12; // default
                $randHourType = rand(1, 100);
                if ($randHourType <= 10) {
                    $hour = rand(0, 5); // late night
                } elseif ($randHourType <= 35) {
                    $hour = rand(6, 11); // morning
                } elseif ($randHourType <= 75) {
                    $hour = rand(12, 17); // afternoon
                } else {
                    $hour = rand(18, 23); // evening/night
                }

                $minute = rand(0, 59);
                $second = rand(0, 59);
                
                $visitTime = $currentDate->copy()->setTime($hour, $minute, $second);

                // Build each step of the clickstream sequentially
                foreach ($pathFlow as $stepIdx => $step) {
                    // Add standard chronological interval between page clicks (10s to 3m)
                    if ($stepIdx > 0) {
                        $visitTime = $visitTime->copy()->addSeconds(rand(10, 180));
                    }

                    // Protect against future-dated timestamps
                    if ($visitTime->isFuture()) {
                        break;
                    }

                    PageView::create([
                        'url' => $appUrl . $step['path'],
                        'page_name' => $step['name'],
                        'ip_address' => $visitor['ip'],
                        'user_agent' => $visitor['ua'],
                        'browser' => $visitor['browser'],
                        'platform' => $visitor['platform'],
                        'device_type' => $visitor['device'],
                        'referer' => ($stepIdx === 0) ? $visitor['referer'] : $appUrl . $pathFlow[$stepIdx - 1]['path'],
                        'country' => $visitor['location'],
                        'session_id' => $sessionId,
                        'visited_at' => $visitTime,
                    ]);
                }
            }
        }

        // 3. Guarantee that we have at least one active realtime session in the last 2 minutes
        // This ensures the "Pengunjung Aktif Saat Ini" metric shows real-time activity instantly on first seed!
        $activeUser = $visitorPool[rand(0, count($visitorPool) - 1)];
        $activeSessionId = Str::uuid()->toString();
        
        PageView::create([
            'url' => $appUrl . '/',
            'page_name' => 'Homepage',
            'ip_address' => $activeUser['ip'],
            'user_agent' => $activeUser['ua'],
            'browser' => $activeUser['browser'],
            'platform' => $activeUser['platform'],
            'device_type' => $activeUser['device'],
            'referer' => $activeUser['referer'],
            'country' => $activeUser['location'],
            'session_id' => $activeSessionId,
            'visited_at' => Carbon::now()->subSeconds(15),
        ]);

        PageView::create([
            'url' => $appUrl . '/menu',
            'page_name' => 'Menu',
            'ip_address' => $activeUser['ip'],
            'user_agent' => $activeUser['ua'],
            'browser' => $activeUser['browser'],
            'platform' => $activeUser['platform'],
            'device_type' => $activeUser['device'],
            'referer' => $appUrl . '/',
            'country' => $activeUser['location'],
            'session_id' => $activeSessionId,
            'visited_at' => Carbon::now()->subSeconds(5),
        ]);
    }
}
