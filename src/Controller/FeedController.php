<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FeedController extends AbstractController
{
    /**
     * @Route("/feed", name="view_feed")
     */
    public function view(): Response
    {
        return new Response('<h1>Welcome to Feed</h1>');
    }
}
