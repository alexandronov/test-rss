<?php

namespace App\Service\RssReader;

use App\ValueObject\Feed;
use App\ValueObject\FeedEntry;

class XmlRssParser implements RssParserInterface
{
    public function parse(string $data): Feed
    {
        $xml = simplexml_load_string($data);

        $feed = new Feed($xml->title);

        foreach ($xml->entry as $item) {
            $entry = $this->createEntry($item);

            $feed->add($entry);
        }


        return $feed;
    }

    private function createEntry(\SimpleXMLElement $element): FeedEntry
    {
        return new FeedEntry(
            $element->title,
            $element->summary,
            $element->author->name
        );
    }
}
