<?php

namespace App\ValueObject;

class FeedEntry
{
    /**
     * @var string
     */
    private string $title;
    /**
     * @var string
     */
    private string $summary;
    /**
     * @var string
     */
    private string $authorName;

    public function __construct(string $title, string $summary, string $authorName)
    {
        $this->title = $title;
        $this->summary = $summary;
        $this->authorName = $authorName;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getSummary(): string
    {
        return $this->summary;
    }

    /**
     * @return string
     */
    public function getAuthorName(): string
    {
        return $this->authorName;
    }

    public function toString(): string
    {
        return strip_tags($this->title) . ' ' . strip_tags($this->summary);
    }

}
