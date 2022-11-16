<?php

namespace App\Controller;

use App\Entity\Artist;
use App\Form\ArtistModifyType;
use App\Repository\ArtistRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/artist', name: 'artist_')]
class ArtistController extends AbstractController
{
    #[Route('/', name: 'showAll')]
    public function showAll(ArtistRepository $artistRepository): Response
    {
        $artists = $artistRepository->findAll();

        return $this->render('artist/index.html.twig', [
            'artists' => $artists,
            ]);
    }

    #[Route('/profil'), name: 'profil']
    public function show(): Response
    {

    }

}
