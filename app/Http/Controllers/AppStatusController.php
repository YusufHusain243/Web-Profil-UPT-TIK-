<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\Pool;
use Illuminate\Http\Client\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AppStatusController extends Controller
{
    /**
     * Check the status of a list of allowed UPR system URLs in parallel.
     */
    public function check(Request $request): JsonResponse
    {
        $urls = $request->input('urls', []);

        if (empty($urls)) {
            return response()->json([]);
        }

        $results = [];
        $validUrls = [];

        foreach ($urls as $url) {
            if (! $url || $url === '#' || trim($url) === '') {
                $results[$url] = 'maintenance';
            } elseif (! $this->isAllowedUrl($url)) {
                // Reject URLs not from the UPR domain to prevent SSRF
                $results[$url] = 'maintenance';
            } else {
                $validUrls[] = $url;
                $results[$url] = 'issue';
            }
        }

        if (empty($validUrls)) {
            return response()->json($results);
        }

        // Use Http::pool to check all URLs in parallel
        $responses = Http::pool(fn (Pool $pool) => collect($validUrls)->map(
            fn ($url) => $pool->as($url)->timeout(5)->connectTimeout(3)->get($url)
        ));

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

    /**
     * Only allow HTTPS URLs under the UPR domain to prevent SSRF attacks.
     */
    private function isAllowedUrl(string $url): bool
    {
        $parsed = parse_url($url);

        if (! isset($parsed['scheme'], $parsed['host'])) {
            return false;
        }

        if ($parsed['scheme'] !== 'https') {
            return false;
        }

        $host = $parsed['host'];

        return $host === 'upr.ac.id' || str_ends_with($host, '.upr.ac.id');
    }
}
