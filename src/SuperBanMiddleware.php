<?php

namespace EdenLife\SuperBan;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Cache\Repository as CacheRepository;
use Illuminate\Cache\RateLimiter;

class SuperBanMiddleware
{
    protected $cache;
    protected $limiter;

    public function __construct(CacheRepository $cache, RateLimiter $limiter)
    {
        $this->cache = $cache;
        $this->limiter = $limiter;
    }

    public function handle(Request $request, Closure $next, $limit = 200, $interval = 2, $banDuration = 1440)
    {
        $key = $this->resolveKey($request);

        if ($this->limiter->tooManyAttempts($key, $limit)) {
            // Perform banning logic here
            $this->banClient($key, $banDuration);

            return response('Too Many Attempts.', 429);
        }

        $this->limiter->hit($key, $interval);

        return $next($request);
    }

    protected function resolveKey(Request $request)
    {
        // Determine how to uniquely identify the client (IP, user ID, email, etc.)
        // For simplicity, using IP address as an example here
        return $request->ip();
    }

    protected function banClient($key, $banDuration)
    {
        // Perform the ban logic here, e.g., store the ban in cache
        $this->cache->put("SuperBan:$key", true, $banDuration);
    }
}
