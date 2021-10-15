<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends AbstractController
{
    // #[Route('/search', name: 'search')]
    public function index(Request $request): Response
    {
        $results = null;
        $query = $request->query->get('search');

        if (!empty($query)) {
            $results = $this->getSearchedPosts($query);
        }

        return $this->render('search/index.html.twig', [
            'results' => $results,
            'query' => $query,
        ]);
    }

    // #[Route('/ajax-search', name: 'ajax_search')]
    public function ajaxSearch(Request $request): Response
    {
        $results = null;
        $query = $request->query->get('search');

        if (!empty($query)) {
            $posts = $this->getSearchedPosts($query);
        }

        foreach ($posts as $post){
            $results[] = [
                "id" => $post->getId(),
                "title" => $post->getTitle(),
            ];
        }

        return new Response(json_encode($results));
    }

    private function getSearchedPosts (string $query): array
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repo = $entityManager->getRepository("App:Post");
        
        return $repo->createQueryBuilder('post')
            ->where('post.title LIKE :search')
            ->orWhere('post.content LIKE :search')
            ->setParameter(':search', "%${query}%")
            ->getQuery()
            ->getResult();
    }
}
