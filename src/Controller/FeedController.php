<?php

namespace App\Controller;

use App\Service\RssReader\RssParserInterface;
use App\Service\RssReader\RssReaderInterface;
use App\Service\WordFrequencyCounterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FeedController extends AbstractController
{
    /**
     * @Route("/feed", name="view_feed")
     */
    public function view(WordFrequencyCounterInterface $wordFrequencyCounter, RssReaderInterface $rssReader, RssParserInterface $rssParser): Response
    {
        $rssContent = $rssReader->read('https://www.theregister.co.uk/software/headlines.atom');

        $feed = $rssParser->parse($rssContent);

        $wordCount = $wordFrequencyCounter->count($feed->toString(), 10);

        return $this->render('feed/feed.html.twig', [
            'feed' => $feed,
            'wordCount' => $wordCount,
        ]);
    }
}
