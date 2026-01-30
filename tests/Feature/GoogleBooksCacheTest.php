<?php

namespace Tests\Feature;

use App\Services\GoogleBooksService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class GoogleBooksCacheTest extends TestCase
{
    public function test_it_caches_api_responses(): void
    {
        Http::fake([
            'googleapis.com/*' => Http::response([
                'items' => [
                    [
                        'volumeInfo' => [
                            'title' => 'Test Book',
                            'authors' => ['Test Author'],
                        ]
                    ]
                ]
            ], 200)
        ]);

        $service = app(GoogleBooksService::class);
        $isbn = '1234567890123';

        Cache::forget("isbn_lookup_{$isbn}");

        $service->fetchByIsbn($isbn);
        $service->fetchByIsbn($isbn);

        Http::assertSentCount(1);
    }
}