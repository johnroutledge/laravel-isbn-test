<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Services\GoogleBooksService;
use Exception;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;
use Livewire\Attributes\Validate;

class IsbnSearch extends Component
{
    #[Validate('required|string|min:10|max:13')]
    public string $isbn = '';

    public ?array $book = null;

    public function search(GoogleBooksService $service): void
    {
        $this->validate();

        $executed = RateLimiter::attempt(
            'search-isbn:' . request()->ip(),
            $perMinute = 5,
            function() use ($service) {
                $this->executeSearch($service);
            }
        );

        if (! $executed) {
            $seconds = RateLimiter::availableIn('search-isbn:' . request()->ip());
            $this->addError('isbn', "Too many requests. Please try again in {$seconds} seconds.");
        }
    }

    private function executeSearch(GoogleBooksService $service): void
    {
        $this->book = null;

        try {
            $bookDto = $service->fetchByIsbn($this->isbn);

            if ($bookDto) {
                $this->book = (array) $bookDto;
            } else {
                $this->addError('isbn', 'No book found for this ISBN.');
            }
        } catch (Exception $e) {
            $this->addError('isbn', 'Service unavailable. Please try again later.');
        }
    }
}