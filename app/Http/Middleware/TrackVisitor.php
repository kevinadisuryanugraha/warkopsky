<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\PageView;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class TrackVisitor
{
    /**
     * Known bot user-agent patterns to exclude from tracking.
     */
    protected array $botPatterns = [
        'bot', 'crawl', 'spider', 'slurp', 'mediapartners',
        'googlebot', 'bingbot', 'yandex', 'baidu', 'duckduck',
        'facebookexternalhit', 'twitterbot', 'linkedinbot',
        'whatsapp', 'telegrambot', 'discordbot', 'applebot',
        'semrush', 'ahrefs', 'mj12bot', 'dotbot', 'petalbot',
        'bytespider', 'gptbot', 'chatgpt', 'claude',
        'curl', 'wget', 'python-requests', 'axios', 'postman',
        'lighthouse', 'pagespeed', 'gtmetrix', 'pingdom',
    ];

    /**
     * Map URL paths to friendly page names.
     */
    protected array $pageNameMap = [
        '/'         => 'Homepage',
        '/menu'     => 'Menu',
        '/galeri'   => 'Galeri',
        '/stories'  => 'Stories',
        '/tentang'  => 'Tentang Kami',
        '/kontak'   => 'Kontak',
    ];

    /**
     * Handle an incoming request — track the visitor.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Process the request first (don't block)
        $response = $next($request);

        // Only track successful GET requests on HTML pages
        if (
            $request->method() !== 'GET' ||
            $request->ajax() ||
            $request->wantsJson() ||
            !$response instanceof Response ||
            $response->getStatusCode() >= 400
        ) {
            return $response;
        }

        // Skip if the response is not HTML
        $contentType = $response->headers->get('Content-Type', '');
        if (!str_contains($contentType, 'text/html')) {
            return $response;
        }

        $userAgent = $request->userAgent() ?? '';

        // Exclude bots
        if ($this->isBot($userAgent)) {
            return $response;
        }

        // Skip asset requests that somehow get through
        $path = $request->path();
        if (preg_match('/\.(css|js|jpg|jpeg|png|gif|svg|webp|ico|woff2?|ttf|eot|map)$/i', $path)) {
            return $response;
        }

        try {
            $ip = $request->ip() ?? '127.0.0.1';
            $location = 'Localhost (Bekasi, Indonesia)';

            // Detect if local/private IP
            $isLocalIp = in_array($ip, ['127.0.0.1', '::1']) || 
                         str_starts_with($ip, '192.168.') || 
                         str_starts_with($ip, '10.') || 
                         preg_match('/^172\.(1[6-9]|2[0-9]|3[0-1])\./', $ip);

            if (!$isLocalIp) {
                try {
                    $location = Cache::remember("ip-loc-{$ip}", 86400 * 7, function () use ($ip) {
                        try {
                            $apiResponse = Http::timeout(1.0)->get("http://ip-api.com/json/{$ip}");
                            if ($apiResponse->successful()) {
                                $data = $apiResponse->json();
                                if (($data['status'] ?? '') === 'success') {
                                    $city = $data['city'] ?? '';
                                    $regionName = $data['regionName'] ?? '';
                                    $countryName = $data['country'] ?? '';
                                    $isp = $data['isp'] ?? '';
                                    return trim("$city, $regionName, $countryName ($isp)", ", ");
                                }
                            }
                        } catch (\Throwable $apiEx) {
                            // ignore API error
                        }
                        return 'Unknown Location';
                    });
                } catch (\Throwable $cacheEx) {
                    $location = 'Unknown Location';
                }
            }

            PageView::create([
                'url'         => $request->fullUrl(),
                'page_name'   => $this->resolvePageName($request),
                'ip_address'  => $ip,
                'user_agent'  => mb_substr($userAgent, 0, 500),
                'browser'     => $this->parseBrowser($userAgent),
                'platform'    => $this->parsePlatform($userAgent),
                'device_type' => $this->parseDeviceType($userAgent),
                'referer'     => $request->header('referer') ? mb_substr($request->header('referer'), 0, 500) : null,
                'country'     => $location,
                'session_id'  => $request->session()->getId(),
                'visited_at'  => Carbon::now(),
            ]);
        } catch (\Throwable $e) {
            // Silently fail — analytics should NEVER break the site
            report($e);
        }

        return $response;
    }

    /**
     * Check if the user agent belongs to a bot.
     */
    protected function isBot(string $userAgent): bool
    {
        $ua = strtolower($userAgent);
        foreach ($this->botPatterns as $pattern) {
            if (str_contains($ua, $pattern)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Resolve a friendly page name from the request path.
     */
    protected function resolvePageName(Request $request): string
    {
        $path = '/' . ltrim($request->path(), '/');

        // Exact match
        if (isset($this->pageNameMap[$path])) {
            return $this->pageNameMap[$path];
        }

        // Fallback: capitalize the first path segment
        $segments = explode('/', trim($path, '/'));
        return ucfirst($segments[0] ?? 'Other');
    }

    /**
     * Parse browser name from user agent string.
     */
    protected function parseBrowser(string $ua): string
    {
        if (empty($ua)) return 'Unknown';

        // Order matters: check specific browsers first
        $browsers = [
            'Edg'       => 'Edge',
            'OPR'       => 'Opera',
            'Opera'     => 'Opera',
            'Brave'     => 'Brave',
            'Vivaldi'   => 'Vivaldi',
            'YaBrowser' => 'Yandex',
            'SamsungBrowser' => 'Samsung Internet',
            'UCBrowser' => 'UC Browser',
            'Chrome'    => 'Chrome',
            'Safari'    => 'Safari',
            'Firefox'   => 'Firefox',
            'MSIE'      => 'Internet Explorer',
            'Trident'   => 'Internet Explorer',
        ];

        foreach ($browsers as $key => $name) {
            if (str_contains($ua, $key)) {
                return $name;
            }
        }

        return 'Other';
    }

    /**
     * Parse platform/OS name from user agent string.
     */
    protected function parsePlatform(string $ua): string
    {
        if (empty($ua)) return 'Unknown';

        $platforms = [
            'Windows NT 10' => 'Windows 10+',
            'Windows NT 6.3' => 'Windows 8.1',
            'Windows NT 6.1' => 'Windows 7',
            'Windows'   => 'Windows',
            'Macintosh' => 'macOS',
            'Mac OS X'  => 'macOS',
            'iPhone'    => 'iOS',
            'iPad'      => 'iPadOS',
            'Android'   => 'Android',
            'Linux'     => 'Linux',
            'CrOS'      => 'ChromeOS',
        ];

        foreach ($platforms as $key => $name) {
            if (str_contains($ua, $key)) {
                return $name;
            }
        }

        return 'Other';
    }

    /**
     * Parse device type from user agent string.
     */
    protected function parseDeviceType(string $ua): string
    {
        if (empty($ua)) return 'desktop';

        $ua = strtolower($ua);

        // Tablet detection (must be before mobile)
        if (str_contains($ua, 'ipad') || str_contains($ua, 'tablet') ||
            (str_contains($ua, 'android') && !str_contains($ua, 'mobile'))) {
            return 'tablet';
        }

        // Mobile detection
        if (str_contains($ua, 'mobile') || str_contains($ua, 'iphone') ||
            str_contains($ua, 'ipod') || str_contains($ua, 'opera mini') ||
            str_contains($ua, 'opera mobi') || str_contains($ua, 'webos')) {
            return 'mobile';
        }

        return 'desktop';
    }
}
