<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Twig\Environment;

#[Route(path: "/", name: "home", methods: ["GET"])]
class HomeController extends AbstractController
{
    private HttpClientInterface $commentClient;
    private int $defaultMaxComments;
    private Environment $twig;

    public function __construct(
        HttpClientInterface $commentClient,
        int $defaultMaxComments,
        Environment $twig
    ) {
        $this->commentClient = $commentClient;
        $this->defaultMaxComments = $defaultMaxComments;
        $this->twig = $twig;
    }

    public function __invoke(Request $request): Response
    {
        /** @var HttpClientInterface $commentClient */
        $response = $this->commentClient->request("GET", "/api/latest/".$this->defaultMaxComments, [
            'verify_peer' => false
        ]);

        $comments = json_decode($response->getContent(), true);

        return new Response(
            $this->twig->render(
                'blog/home.html.twig',
                [
                    'comments' => $comments
                ]
            )
        );
    }
}