<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\Pool;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AppStatusController extends Controller
{
    /**
     * Check the status of a list of URLs in parallel.
     */
    public function check(Request $request)
    {
        $urls = $request->input('urls', []);

        if (empty($urls)) {
            return response()->json([]);
        }

        // Initialize results with maintenance for special URLs
        $results = [];
        $validUrls = [];

        foreach ($urls as $url) {
            // Treat empty strings, null, and '#' (often received as '' after URL parsing) as maintenance
            if (! $url || $url === '#' || trim($url) === '') {
                $results[$url] = 'maintenance';
            } else {
                $validUrls[] = $url;
                $results[$url] = 'issue'; // Default to issue, will be updated by pool
            }
        }

        if (empty($validUrls)) {
            return response()->json($results);
        }

        // Use Http::pool to check all URLs in parallel (asynchronously)
        // This reduces total time from ~80s to ~5s
        $responses = Http::pool(fn (Pool $pool) => collect($validUrls)->map(fn ($url) => $pool->as($url)->timeout(5)->connectTimeout(3)->get($url)
        )
        );

        foreach ($validUrls as $url) {
            $response = $responses[$url];

            if ($response instanceof Response && $response->successful()) {
                $results[$url] = 'operational';
            } else {
                $results[$url] = 'issue';
            }
        }

        return response()->json($results);
    }
}
