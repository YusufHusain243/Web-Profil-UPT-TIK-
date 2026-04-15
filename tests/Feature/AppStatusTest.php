<?php

use Illuminate\Support\Facades\Http;

it('returns empty array when no urls are provided', function () {
    $response = $this->getJson('/api/status-check');

    $response->assertSuccessful();
    $response->assertExactJson([]);
});

it('marks placeholder urls as maintenance', function () {
    // '#' is a special placeholder for systems without a live URL.
    $response = $this->getJson('/api/status-check?urls[]=%23');

    $response->assertSuccessful();
    $response->assertJson(['#' => 'maintenance']);
});

it('rejects non-upr urls to prevent ssrf', function () {
    $response = $this->getJson('/api/status-check?urls[]=https%3A%2F%2Fexample.com');

    $response->assertSuccessful();
    $response->assertJson(['https://example.com' => 'maintenance']);
});

it('rejects http (non-https) urls', function () {
    $response = $this->getJson('/api/status-check?urls[]=http%3A%2F%2Fsia.upr.ac.id');

    $response->assertSuccessful();
    $response->assertJson(['http://sia.upr.ac.id' => 'maintenance']);
});

it('returns operational status for reachable upr urls', function () {
    Http::fake(['https://sia.upr.ac.id' => Http::response('ok', 200)]);

    $response = $this->getJson('/api/status-check?urls[]=https%3A%2F%2Fsia.upr.ac.id');

    $response->assertSuccessful();
    $response->assertJson(['https://sia.upr.ac.id' => 'operational']);
});

it('returns issue status for unreachable upr urls', function () {
    Http::fake(['https://down.upr.ac.id' => Http::response('error', 500)]);

    $response = $this->getJson('/api/status-check?urls[]=https%3A%2F%2Fdown.upr.ac.id');

    $response->assertSuccessful();
    $response->assertJson(['https://down.upr.ac.id' => 'issue']);
});

it('handles mixed url statuses in a single batch', function () {
    Http::fake([
        'https://sia.upr.ac.id' => Http::response('ok', 200),
        'https://down.upr.ac.id' => Http::response('error', 503),
    ]);

    $response = $this->getJson(
        '/api/status-check?urls[]=https%3A%2F%2Fsia.upr.ac.id&urls[]=%23&urls[]=https%3A%2F%2Fdown.upr.ac.id'
    );

    $response->assertSuccessful();
    $response->assertJson([
        'https://sia.upr.ac.id' => 'operational',
        '#' => 'maintenance',
        'https://down.upr.ac.id' => 'issue',
    ]);
});
