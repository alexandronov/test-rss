<?php

namespace App\Service;

class WordFrequencyCounter implements WordFrequencyCounterInterface
{
    private array $excludedWords = [
        'the', 'be', 'to', 'of', 'and', 'a', 'in', 'that', 'have', 'I',
        'it', 'for', 'not', 'on', 'with', 'he', 'as', 'you', 'do', 'at',
        'this', 'but', 'his', 'by', 'from', 'they', 'we', 'say', 'her', 'she',
        'or', 'an', 'will', 'my', 'one', 'all', 'would', 'there', 'their', 'what',
        'so', 'up', 'out', 'if', 'about', 'who', 'get', 'which', 'go', 'me',
    ];

    public function count(string $sourceString, int $limit): array
    {
        $words = array_count_values(str_word_count($sourceString, 1));

        arsort($words);

        $words = array_diff_key($words, array_flip($this->excludedWords));

        return array_slice($words, 0, $limit);
    }
}
