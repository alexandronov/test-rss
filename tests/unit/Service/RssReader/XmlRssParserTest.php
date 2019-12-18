<?php

namespace App\Tests\Unit\Service\RssReader;


use App\Service\RssReader\XmlRssParser;
use App\ValueObject\FeedEntry;

class XmlRssParserTest extends \Codeception\Test\Unit
{
    public function testParse(): void
    {
        $parser = new XmlRssParser();

        $feed = $parser->parse($this->xmlString());

        $this->assertEquals('Expected feed title', $feed->title());
        $this->assertCount(2, $feed->entries());

        $entries = $feed->entries();
        /** @var FeedEntry $firstEntry */
        $firstEntry = reset($entries);

        $this->assertEquals('First Title', $firstEntry->getTitle());
        $this->assertEquals('Some summary', $firstEntry->getSummary());
        $this->assertEquals('Tim Anderson', $firstEntry->getAuthorName());
    }

    private function xmlString(): string
    {
        return <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<feed xmlns="http://www.w3.org/2005/Atom" xml:lang="en">
  <id>tag:theregister.co.uk,2005:feed/theregister.co.uk/software/</id>
  <title>Expected feed title</title>
  <link rel="self" type="application/atom+xml" href="https://www.theregister.co.uk/software/headlines.atom"/>
  <link rel="alternate" type="text/html" href="https://www.theregister.co.uk/software/"/>
  <rights>Copyright Â© 2019, Situation Publishing</rights>
  <author>
    <name>Team Register</name>
    <email>webmaster@theregister.co.uk</email>
    <uri>https://www.theregister.co.uk/odds/about/contact/</uri>
  </author>
  <icon>https://www.theregister.co.uk/Design/graphics/icons/favicon.png</icon>
  <subtitle>Biting the hand that feeds IT â€” sci/tech news and views for the world</subtitle>
  <logo>https://www.theregister.co.uk/Design/graphics/Reg_default/The_Register_r.png</logo>
  <updated>2019-12-17T14:30:07Z</updated>
  <entry>
    <id>tag:theregister.co.uk,2005:story206249</id>
    <updated>2019-12-17T14:30:07Z</updated>
    <author>
      <name>Tim Anderson</name>
      <uri>https://search.theregister.co.uk/?author=Tim%20Anderson</uri>
    </author>
    <link rel="alternate" type="text/html" href="https://go.theregister.co.uk/feed/www.theregister.co.uk/2019/12/17/not_so_swift_ibm_pulls_back_following_review_of_open_source_priorities/"/>
    <title type="html">First Title</title>
    <summary type="html" xml:base="https://www.theregister.co.uk/">Some summary</summary>
  </entry>
    <entry>
    <id>tag:theregister.co.uk,2005:story206243</id>
    <updated>2019-12-17T01:48:13Z</updated>
    <author>
      <name>Thomas Claburn</name>
      <uri>https://search.theregister.co.uk/?author=Thomas%20Claburn</uri>
    </author>
    <link rel="alternate" type="text/html" href="https://go.theregister.co.uk/feed/www.theregister.co.uk/2019/12/17/737_max_halt/"/>
    <title type="html">Second title</title>
    <summary type="html" xml:base="https://www.theregister.co.uk/">Another summary</summary>
  </entry>
</feed>
XML;

    }
}
