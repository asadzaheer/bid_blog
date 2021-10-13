<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'search')]
    public function index(Request $request): Response
    {
        $results = null;
        $query = $request->query->get('search');

        if (!empty($query)) {
            $entityManager = $this->getDoctrine()->getManager();
            $repo = $entityManager->getRepository("App:Post");

            $results = $repo->createQueryBuilder('post')
                ->where('post.title LIKE :search')
                ->orWhere('post.content LIKE :search')
                ->setParameter(':search', "%${query}%")
                ->getQuery()
                ->getResult();
        }

        return $this->render('search/index.html.twig', [
            'results' => $results,
            'query' => $query,
        ]);
    }
}
