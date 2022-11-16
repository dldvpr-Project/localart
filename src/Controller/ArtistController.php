<?php

namespace App\Controller;

use App\Entity\Artist;
use App\Entity\User;
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

    #[Route('/profil', name: 'profil')]
    public function show(ArtistRepository $artistRepository): Response
    {

        if ($this->getUser() === null) {
            return $this->redirectToRoute('artist_showAll');
        }

        /** @var User $user * */
        $user = $this->getUser();
        $artistId = $user->getId();

        $artist = $artistRepository->findOneBy(['id' => $artistId]);

        return $this->render('artist/profil.html.twig', [
            '$artist' => $artist
        ]);
    }

    #[Route('/modify-profil', name: 'edit')]
    public function edit(ArtistRepository $artistRepository): Response
    {

        if ($this->getUser() === null) {
            return $this->redirectToRoute('artist_showAll');
        }

        /** @var User $user * */
        $user = $this->getUser();
        $artistId = $user->getId();

        $artist = $artistRepository->findOneBy(['id' => $artistId]);

        return $this->render('artist/profil.html.twig', [
            '$artist' => $artist
        ]);
    }

}
