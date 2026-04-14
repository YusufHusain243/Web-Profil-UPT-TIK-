<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AppStatusController extends Controller
{
    /**
     * Check the status of a list of URLs.
     */
    public function check(Request $request)
    {
        $urls = $request->input('urls', []);

        if (empty($urls)) {
            return response()->json([]);
        }

        $results = [];

        foreach ($urls as $url) {
            // Normalize URL
            if (! $url || $url === '#') {
                $results[$url] = 'maintenance';

                continue;
            }

            try {
                // Perform a real server-side HTTP check with a strict timeout
                // We use connectTimeout to fail fast if the server is unreachable
                $response = Http::timeout(5)
                    ->connectTimeout(3)
                    ->get($url);

                if ($response->successful()) {
                    $results[$url] = 'operational';
                } else {
                    // Even if it's 404 or 500, we consider it an issue in the monitoring context
                    $results[$url] = 'issue';
                }
            } catch (\Exception $e) {
                // If it timeouts or DNS fails, it's definitely an issue
                $results[$url] = 'issue';
            }
        }

        return response()->json($results);
    }
}
