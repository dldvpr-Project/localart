<?php

namespace App\Controller;

use App\Entity\ArtCard;
use App\Repository\ViewRandCardRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ArtCardRepository;

#[Route('/', name: 'home_')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ViewRandCardRepository $viewRandCardRepository, ArtCardRepository $artCardRepository): Response
    {
        $randCard = $viewRandCardRepository->findAll();
        if (empty($randCard) || !is_array($randCard)) {
            throw $this->createNotFoundException();
        }

        $artCards = $artCardRepository->findBy(['id' => $randCard]);
        if (empty($artCards) || !is_array($artCards)) {
            throw $this->createNotFoundException();
        }

        $artCard = array_pop($artCards);


        return $this->render('home/index.html.twig', [
            'artCards' => $artCards,
            'artCard' => $artCard,
        ]);
    }
}
