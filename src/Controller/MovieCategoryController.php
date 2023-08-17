<?php

namespace App\Controller;

use App\Entity\MovieCategory;
use App\Form\MovieCategoryType;
use App\Repository\MovieCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/category')]
class MovieCategoryController extends AbstractController
{
    #[Route('/', name: 'app_movie_category_index', methods: ['GET'])]
    public function index(MovieCategoryRepository $movieCategoryRepository): Response
    {
        return $this->render('movie_category/index.html.twig', [
            'movie_categories' => $movieCategoryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_movie_category_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $movieCategory = new MovieCategory();
        $form = $this->createForm(MovieCategoryType::class, $movieCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($movieCategory);
            $entityManager->flush();

            return $this->redirectToRoute('app_movie_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('movie_category/new.html.twig', [
            'movie_category' => $movieCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_movie_category_show', methods: ['GET'])]
    public function show(MovieCategory $movieCategory): Response
    {
        return $this->render('movie_category/show.html.twig', [
            'movie_category' => $movieCategory,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_movie_category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MovieCategory $movieCategory, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MovieCategoryType::class, $movieCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_movie_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('movie_category/edit.html.twig', [
            'movie_category' => $movieCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_movie_category_delete', methods: ['POST'])]
    public function delete(Request $request, MovieCategory $movieCategory, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$movieCategory->getId(), $request->request->get('_token'))) {
            $entityManager->remove($movieCategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_movie_category_index', [], Response::HTTP_SEE_OTHER);
    }
}
