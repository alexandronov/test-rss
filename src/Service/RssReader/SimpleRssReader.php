<?php

namespace App\Service\RssReader;

class SimpleRssReader implements RssReaderInterface
{
    public function read(string $sourceUrl): string
    {
        return file_get_contents($sourceUrl);
    }
}
