<?php

declare(strict_types=1);

namespace App\Controller;


use App\Model\Post;
use App\Repository\InMemoryPostRepository;
use App\Repository\PostRepository;
use \InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Twig\Environment;

#[Route(path: "/page/{id}", name: "post", methods: ["GET"])]
class PageController
{
    private HttpClientInterface $commentClient;
    private Environment $twig;
    private PostRepository $postRepository;

    public function __construct(
        HttpClientInterface $commentClient,
        Environment $twig,
        PostRepository $postRepository
    ) {
        $this->commentClient = $commentClient;
        $this->twig = $twig;
        $this->postRepository = $postRepository;
    }

    public function __invoke(Request $request, int $id): Response
    {
        $repository= new InMemoryPostRepository();
        $post = $repository->find($id);
        if(!$post instanceof Post){
            Throw new InvalidArgumentException("For this demo please choose article id equal to 1 or 2");
        }

        /** @var HttpClientInterface $commentClient */
        $response = $this->commentClient->request("GET", "/api/posts/".$id."/comments", [
            'verify_peer' => false
        ]);

        $comments = json_decode($response->getContent(), true);

        return new Response(
            content: $this->twig->render(
                'blog/post.html.twig', [
                    'post' => $post,
                    'comments' => $comments
                ]
            )
            ,status:  Response::HTTP_OK);
    }
}