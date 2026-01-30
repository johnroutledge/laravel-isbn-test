<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;
use Livewire\Livewire;
use App\Livewire\IsbnSearch;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;

class IsbnSearchTest extends TestCase
{
    public function test_it_displays_book_details_on_successful_search(): void
    {
        Http::fake([
            'googleapis.com/*' => Http::response([
                'items' => [['volumeInfo' => ['title' => 'Refactoring', 'authors' => ['Martin Fowler']]]]
            ], 200)
        ]);

        Livewire::test(IsbnSearch::class)
            ->set('isbn', '9780134757599')
            ->call('search')
            ->assertSee('Refactoring')
            ->assertSee('Martin Fowler');
    }

    public function test_it_rate_limits_excessive_searches(): void
    {
        RateLimiter::clear('search-isbn:' . request()->ip());

        for ($i = 0; $i < 5; $i++) {
            Livewire::test(IsbnSearch::class)
                ->set('isbn', '9780132350884')
                ->call('search');
        }

        Livewire::test(IsbnSearch::class)
            ->set('isbn', '9780132350884')
            ->call('search')
            ->assertHasErrors(['isbn'])
            ->assertSee('Too many requests');
    }
}