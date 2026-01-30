<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\BookDataDto;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class GoogleBooksService
{
    public function fetchByIsbn(string $isbn): ?BookDataDto
    {
        $cacheKey = "isbn_lookup_{$isbn}";

        return Cache::remember($cacheKey, now()->addDay(), function () use ($isbn) {
            $response = Http::get(Config::get('services.google_books.base_url') . 'volumes', [
                'q' => "isbn:{$isbn}",
                'key' => Config::get('services.google_books.key'),
            ]);

            if ($response->failed()) {
                throw new Exception('Google Books API is unreachable.');
            }

            $data = $response->json();

            if (!isset($data['items']) || count($data['items']) === 0) {
                return null;
            }

            return BookDataDto::fromApi($data['items'][0]);
        });
    }
}