<?php

namespace App\Tests\Unit\Service;

use App\Service\WordFrequencyCounter;

class WordFrequencyCounterTest extends \Codeception\Test\Unit
{
    private WordFrequencyCounter $counter;

    protected function _setUp()
    {
        $this->counter = new WordFrequencyCounter();

        return parent::_setUp();
    }

    /**
     * @dataProvider wordCountDataProvider
     */
    public function testWordCount(string $sourceText, array $expectedResult): void
    {
        $result = $this->counter->count($sourceText, 10);

        $this->assertEquals($expectedResult, $result);
    }

    public function testLimit(): void
    {
        $sourceString = 'foo foo bar baz php php php null bar bar bar baz bar';

        $expectedLimit = 3;

        $result = $this->counter->count($sourceString, $expectedLimit);

        $this->assertCount($expectedLimit, $result);
    }

    public function wordCountDataProvider(): array
    {
        return [
            [
                'sourceText' => 'this string has this some random random random string string here random this this this',
                'expectedResult' => [
                    'random' => 4,
                    'string' => 3,
                    'has' => 1,
                    'some' => 1,
                    'here' => 1,
                ],
            ],
            [
                'sourceText' => 'if I random get some random string I get some random get',
                'expectedResult' => [
                    'random' => 3,
                    'some' => 2,
                    'string' => 1,
                ],
            ],
            [
                'sourceText' => 'this this this will not have effect on me',
                'expectedResult' => [
                    'effect' => 1,
                ],
            ],
            [
                'sourceText' => 'this one will say go to this all',
                'expectedResult' => [],
            ],
        ];
    }
}
