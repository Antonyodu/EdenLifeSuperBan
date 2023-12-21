<?php

namespace EdenLife\Tests\Feature;
use EdenLife\SuperBanMiddleware;
use Tests\TestCase;
use Illuminate\Support\Facades\Route;

class SuperBanTest extends TestCase
{

    public function testUserIsBannedAfterExceedingRateLimit()
    {
        $this->withoutExceptionHandling();

        // Set up the route with SuperbanMiddleware
        Route::middleware([SuperBanMiddleware::class . ':2,1,10'])->get('/thisroute', function () {
            return 'OK';
        });

        // Run two requests to trigger rate limits and banning 
        $first = $this->withMiddleware(SuperbanMiddleware::class, '2,1,10')->get('/thisroute');
        $second = $this->withMiddleware(SuperbanMiddleware::class, '2,1,10')->get('/thisroute');

        // This request should return 429
        $third = $this->withMiddleware(SuperbanMiddleware::class, '2,1,10')->get('/thisroute');

        // Assert the responses
        $first->assertStatus(200);
        $second->assertStatus(200);
        $third->assertStatus(429);
    }
}
