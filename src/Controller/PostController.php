<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\PostCommentType;
use App\Form\PostType;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

// #[Route('/')]
class PostController extends AbstractController
{
    #[Route('/', name: 'post_index', methods: ['GET'])]
    public function index(PostRepository $postRepository): Response
    {
        return $this->render('post/index.html.twig', [
            'posts' => $postRepository->findAll(),
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     */
    // #[Route('/post/new', name: 'post_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('post/new.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    // #[Route('/post/{id}', name: 'post_show', methods: ['GET', 'POST'])]
    public function show(Post $post, Request $request): Response
    {
        $comment = new Comment();
        $form = $this->createForm(PostCommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $comment->setIsHidden(0);
            $comment->setPost($post);
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('post_show', ['id' => $post->getId()], Response::HTTP_SEE_OTHER);
        }

        $query = $request->query->get('search');

        if (!empty($query)) {
            preg_match_all('/\w*' . $query . '\w*/', $post->getContent(), $matches);
            $highlight = array();
            foreach ($matches[0] as $key => $match) {
                similar_text($query, $match, $perc);
                if ($perc >= 75 && $perc <= 85) {
                    $highlight[] = '<span class="orange-bg">' . $match . '</span>';
                } else if ($perc > 85 && $perc <= 95) {
                    $highlight[] = '<span class="yellow-bg">' . $match . '</span>';
                } else if ($perc > 95) {
                    $highlight[] = '<span class="green-bg">' . $match . '</span>';
                }
            }

            if (count($highlight) > 0) {
                // echo $matches[0];
                // echo $highlight;
                $post->setContent(str_replace($matches[0], $highlight, $post->getContent()));
            }
        }

        return $this->renderForm('post/show.html.twig', [
            'post' => $post,
            'comment' => $comment,
            'form' => $form,
            'query' => $query
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     */
    // #[Route('/post/{id}/edit', name: 'post_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Post $post): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('post/edit.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     */
    // #[Route('/post/{id}', name: 'post_delete', methods: ['POST'])]
    public function delete(Request $request, Post $post): Response
    {
        if ($this->isCsrfTokenValid('delete' . $post->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('post_index', [], Response::HTTP_SEE_OTHER);
    }
}
