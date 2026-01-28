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
