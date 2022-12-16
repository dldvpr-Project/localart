<?php

namespace App\Controller;

use App\Repository\ArtCardRepository;
use App\Repository\ViewRandCardRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/', name: 'home_')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ViewRandCardRepository $viewRandCardRepository, ArtCardRepository $artCardRepository): Response
    {
        $randArt = $viewRandCardRepository->findAll();
        if (empty($randArt) || !is_array($randArt)) {
            throw $this->createNotFoundException();
        }

        $arrayArt = $artCardRepository->findBy(['id' => $randArt]);
        if (empty($arrayArt) || !is_array($arrayArt)) {
            throw $this->createNotFoundException();
        }

        $frontArt = array_pop($arrayArt);


        return $this->render('home/index.html.twig', [
            'arrayArt' => $arrayArt,
            'frontArt' => $frontArt,
        ]);
    }
}
