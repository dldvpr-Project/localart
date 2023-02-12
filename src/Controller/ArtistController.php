<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AdminModifyArtistType;
use App\Repository\ArtistRepository;
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

    #[Route('/profil', name: 'myProfil')]
    public function myProfil(ArtistRepository $artistRepository): Response
    {

        if ($this->getUser() === null) {
            return $this->redirectToRoute('home_index');
        }

        /** @var User $user * */
        $user = $this->getUser();
        $artistId = $user->getId();

        $artist = $artistRepository->findOneBy(['id' => $artistId]);

        return $this->render('artist/profil.html.twig', [
            'artist' => $artist
        ]);
    }

    #[Route('/profil/{id}', name: 'profil')]
    public function show(ArtistRepository $artistRepository, int $id): Response
    {

        $artist = $artistRepository->findOneBy(['id' => $id]);

        return $this->render('artist/profil.html.twig', [
            'artist' => $artist
        ]);
    }

    #[Route('/modify-profil', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ArtistRepository $artistRepository): Response
    {
        if ($this->getUser() === null) {
            return $this->redirectToRoute('home_index');
        }

        /** @var User $user */
        $artist = $this->getUser();

        $form = $this->createForm(AdminModifyArtistType::class, $artist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $artistRepository->save($artist, true);
            return $this->redirectToRoute('artist_myProfil');
        }

        return $this->renderForm('artist/edit.html.twig', [
            'form' => $form,
            'artist' => $artist
        ]);
    }

}
