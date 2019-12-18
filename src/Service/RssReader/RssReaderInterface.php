<?php

namespace App\Service\RssReader;

interface RssReaderInterface
{
    public function read(string $sourceUrl): string;
}
