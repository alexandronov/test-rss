<?php

namespace App\Service;

interface WordFrequencyCounterInterface
{
    public function count(string $sourceString, int $limit): array;
}
