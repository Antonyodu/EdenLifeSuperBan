<?php

namespace Tests\Feature;

use EdenLife\SuperBan\SuperBanMiddleware;
use Tests\TestCase;
use Illuminate\Support\Facades\Route;

class SuperBanTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRateLimit()
    {
        // Replace the following with your actual route URL
        $routeUrl = 'thisroute';

        // Replace the following with your actual request payload
        $requestData = [];

        // Replace the following with the rate limit and interval
        $limit = 10;

        // Send POST requests to trigger rate limit
        for ($i = 0; $i < $limit + 2; $i++) {
            $response = $this->json('POST', $routeUrl, $requestData);

            if ($i < $limit) {
                // Expecting a successful response for the first $limit requests
                $response->assertStatus(200);
            } else {
                // Expecting a 429 response after hitting the rate limit
                $response->assertStatus(429);
            }


        }
    }

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
