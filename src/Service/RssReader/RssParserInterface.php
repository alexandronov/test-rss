<?php

namespace App\Service\RssReader;

use App\ValueObject\Feed;

interface RssParserInterface
{
    public function parse(string $data): Feed;
}
