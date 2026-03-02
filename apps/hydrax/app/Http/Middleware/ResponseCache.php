<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ResponseCache
{
    /**
     * Handle an incoming request.
     * Cache only safe public GET HTML responses for unauthenticated users.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->isMethod('get')) {
            return $next($request);
        }

        if (Auth::check()) {
            return $next($request);
        }

        if ($request->expectsJson()) {
            return $next($request);
        }

        $key = $this->cacheKey($request);
        $ttl = (int) env('RESPONSE_CACHE_TTL', 60); // seconds

        $cached = Cache::get($key);
        if ($cached && is_array($cached)) {
            return response($cached['content'], $cached['status'], $cached['headers']);
        }

        $response = $next($request);

        // Only cache successful HTML responses without Set-Cookie header
        $status = $response->getStatusCode();
        $contentType = $response->headers->get('Content-Type', '');
        $hasSetCookie = $response->headers->has('Set-Cookie');

        if ($status === 200 && stripos($contentType, 'text/html') !== false && !$hasSetCookie) {
            $store = [
                'content' => $response->getContent(),
                'status' => $status,
                'headers' => $this->filterHeaders($response->headers->all()),
            ];

            try {
                Cache::put($key, $store, $ttl);
            } catch (\Exception $e) {
                // fail silently — don't break page if cache fails
            }
        }

        return $response;
    }

    protected function cacheKey(Request $request)
    {
        return 'resp_cache:' . md5($request->getSchemeAndHttpHost() . $request->getRequestUri());
    }

    protected function filterHeaders(array $headers)
    {
        // Remove headers that may cause issues when restored from cache
        $bad = ['set-cookie', 'transfer-encoding', 'content-length'];
        $out = [];
        foreach ($headers as $name => $values) {
            if (in_array(strtolower($name), $bad, true)) {
                continue;
            }
            $out[$name] = $values;
        }
        return $out;
    }
}
