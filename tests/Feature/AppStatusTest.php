<?php

use Illuminate\Support\Facades\Http;

it('returns empty array when no urls are provided', function () {
    $response = $this->getJson('/api/status-check');

    $response->assertSuccessful();
    $response->assertExactJson([]);
});

it('marks placeholder urls as maintenance', function () {
    // '#' is a special placeholder for systems without a live URL.
    // When URL-encoded as %23 it correctly reaches the server as '#'.
    $response = $this->getJson('/api/status-check?urls[]=%23');

    $response->assertSuccessful();
    $response->assertJson(['#' => 'maintenance']);
});

it('returns operational status for reachable urls', function () {
    Http::fake(['https://example.com' => Http::response('ok', 200)]);

    $response = $this->getJson('/api/status-check?urls[]=https%3A%2F%2Fexample.com');

    $response->assertSuccessful();
    $response->assertJson(['https://example.com' => 'operational']);
});

it('returns issue status for unreachable urls', function () {
    Http::fake(['https://down.example.com' => Http::response('error', 500)]);

    $response = $this->getJson('/api/status-check?urls[]=https%3A%2F%2Fdown.example.com');

    $response->assertSuccessful();
    $response->assertJson(['https://down.example.com' => 'issue']);
});

it('handles mixed url statuses in a single batch', function () {
    Http::fake([
        'https://up.example.com' => Http::response('ok', 200),
        'https://down.example.com' => Http::response('error', 503),
    ]);

    $response = $this->getJson(
        '/api/status-check?urls[]=https%3A%2F%2Fup.example.com&urls[]=%23&urls[]=https%3A%2F%2Fdown.example.com'
    );

    $response->assertSuccessful();
    $response->assertJson([
        'https://up.example.com' => 'operational',
        '#' => 'maintenance',
        'https://down.example.com' => 'issue',
    ]);
});
