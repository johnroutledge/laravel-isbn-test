<?php

declare(strict_types=1);

namespace App\DTOs;

readonly class BookDataDto
{
    public function __construct(
        public string $title,
        public array $authors,
        public ?string $description,
        public ?string $thumbnail,
    ) {}

    public static function fromApi(array $item): self
    {
        $volumeInfo = $item['volumeInfo'] ?? [];

        return new self(
            title: $volumeInfo['title'] ?? 'Unknown Title',
            authors: $volumeInfo['authors'] ?? ['Unknown Author'],
            description: $volumeInfo['description'] ?? null,
            thumbnail: $volumeInfo['imageLinks']['thumbnail'] ?? null,
        );
    }
}