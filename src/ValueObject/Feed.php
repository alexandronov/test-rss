<?php

namespace App\ValueObject;

class Feed
{
    private string $title;

    private array $entries;

    public function __construct(string $title)
    {
        $this->title = $title;
        $this->entries = [];
    }

    public function add(FeedEntry $entry): void
    {
        $this->entries[] = $entry;
    }

    /**
     * @return FeedEntry[]
     */
    public function getEntries(): array
    {
        return $this->entries;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function toString(): string
    {
        $entriesAsString = array_map(fn(FeedEntry $entry) => $entry->toString(), $this->entries);

        return $this->title . ' ' . implode(' ', $entriesAsString);
    }
}
