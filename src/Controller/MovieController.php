<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MovieType;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/movie")]
class MovieController extends AbstractController
{
    #[Route('/', name: 'app_movie')]
    public function index(MovieRepository $repository): Response
    {
        return $this->render('movie/index.html.twig', [
            'movies' => $repository->findAll()
        ]);
    }

    #[Route("/new")]
    public function new(EntityManagerInterface $manager, Request $request):Response{

        $movie = new Movie();
        $movieForm = $this->createForm(MovieType::class,$movie);
        $movieForm->handleRequest($request);
        if ($movieForm->isSubmitted() && $movieForm->isValid()){
            $manager->persist($movie);
            $manager->flush();
        }
        return $this->renderForm("movie/new.html.twig",[
            "movieForm"=>$movieForm
        ]);
    }

}
