<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Artist;
use App\Form\ArtistModifyType;
use App\Repository\ArtistRepository;
use App\Service\ProfilPictureUploader;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
            'artist' => $artist
        ]);
    }

    #[Route('/modify-profil', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ArtistRepository $artistRepository, Artist $artistEntity, ProfilPictureUploader $profilPictureUploader): Response
    {
        if ($this->getUser() === null) {
            return $this->redirectToRoute('artist_showAll');
        }

        /** @var User $user */
        $artist = $this->getUser();

        $form = $this->createForm(ArtistModifyType::class, $artist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $pictureFile */
            $pictureFile = $form->get('profilPicture')->getData();

            $oldFile = $artistEntity->getProfilPicture();
            $pictureFileName = $profilPictureUploader->edit($pictureFile, $oldFile);

            $artistEntity->setProfilPicture($pictureFileName);

            $artistRepository->save($artist, true);
            return $this->redirectToRoute('artist_profil');
        }

        return $this->renderForm('artist/edit.html.twig', [
            'form' => $form,
            'artist' => $artist
        ]);
    }

}
