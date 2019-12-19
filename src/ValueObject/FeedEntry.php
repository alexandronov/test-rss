<?php

namespace App\ValueObject;

class FeedEntry
{
    private string $title;

    private string $summary;

    private string $authorName;

    public function __construct(string $title, string $summary, string $authorName)
    {
        $this->title = $title;
        $this->summary = $summary;
        $this->authorName = $authorName;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getSummary(): string
    {
        return $this->summary;
    }

    public function getAuthorName(): string
    {
        return $this->authorName;
    }

    public function toString(): string
    {
        return strip_tags($this->title) . ' ' . strip_tags($this->summary);
    }
}
