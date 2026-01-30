# Technical assessment: ISBN Book Lookup

The objective of this task assessment is to create a small Laravel project that allows a user to input a book's ISBN number and retrieve book details via the Google Books API.

## Requirements

The following requirements should be met for this task.

### Functional Requirements

- **Search Interface:** A single-page interface built with [Laravel Livewire](https://livewire.laravel.com/). While it doesn’t have to pretty, it should demonstrate a clear understanding of the TALL stack

- **Data Retrieval:** Fetch data from the [Google Books API](https://developers.google.com/books/docs/overview)

- **Performance:** Ensure the project is optimised for performance, and the system doesn’t produce redundant API requests.

- **Loading states:** Provide visual feedback to the user during transition states (e.g. loading)

### Technical Requirements

- **Architecture:**

    - You should demonstrate a strong understanding of controllers, handling data input and abstraction.

    - You should use Laravel’s facades and helpers where possible. Please develop in an extensible way.

- **Testing:** Include a test suite (Pest or PHPUnit). We are looking for:

    - Feature tests of the Livewire component

    - Mocking of the Google Books API integration

- **Configuration:** Endpoints and API keys should be persisted in a configuration file.

- **AI:** For the purposes of this task, please refrain from using AI.

## What are we looking for?

As the project’s focus is primarily backend, some of the key metrics we’ll be measuring on are:

- **Code organisation:** How you decouple the UI from the business logic

- **Security:** Consideration for the security of the implementation, consider API exhaustion, etc.

- **Error handling:** How you gracefully handle errors

- **Data consistency:** The use of Data Transfer objects to pass data between components

- **Test quality:** Your ability to test external dependencies and cover unhappy path scenarios

## Setup

Please fork this repository and submit a pull request on completion with detailed documentation on your approach and rationale for the choices you made.

---

## Approach & Rationale

For the purposes of this task, I built a minimal ISBN search tool using the TALL stack as per the requirements.

1. Architecture: The Service Layer
Instead of putting API logic directly into the Livewire component, I created a GoogleBooksService.

Why: This keeps the component thin and focused on the UI state. It also makes writing test easier. If we ever switched from Google Books to another API, I’d only need to update this one class.

2. Data Handling: DTOs
I used a BookDataDto to move data between the Service and the Component.

Why: Raw API responses from Google are deeply nested and messy. Mapping them to a DTO immediately after the fetch ensures that the rest of the app works with a predictable object.

3. Performance: Caching
I wrapped the API call in Laravel’s Cache::remember.

Why: ISBN data is static—a book's title and author don't change. By caching the results for 24 hours, we avoid hitting the Google API rate limits and provide near-instant results for repeat searches.

4. User Experience & Security
Rate Limiting: I added a simple rate limiter (5 requests per minute) to the search method using Laravel's RateLimiter facade to prevent automated abuse of the API key.

Livewire Validation: Used the #[Validate] attribute for real-time validation of the ISBN format before the request leaves the server.

5. Design Choice
I went with a dark "Zinc" theme using Tailwind CSS and kept the UI minimal to ensure the focus remains on the book metadata.

---

## Project Structure

Key application components relevant to this task:

```
app/
├── DTOs/BookDataDto.php
├── Http/Controllers/BookLookupController.php
├── Livewire/IsbnSearch.php
├── Services/GoogleBooksService.php
resources/views/
├── layouts/app.blade.php
├── livewire/isbn-search.blade.php
├── isbn-lookup.blade.php
tests/Feature/
├── GoogleBooksCacheTest.php
└── IsbnSearchTest.php
```

## Installation

1. Clone the repo and run `composer install`.
2. Copy `.env.example` to `.env`.
3. Add your `GOOGLE_BOOKS_API_KEY` to the `.env` file.
4. Run `php artisan key:generate`.
5. Run `php artisan serve` and visit `localhost:8000`.

To run the tests:

```bash
php artisan test
```