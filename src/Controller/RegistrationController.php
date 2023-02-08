<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Artist;
use App\Form\UserType;
use App\Form\AdminArtistType;
use App\Service\ProfilPictureUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/register', name: 'register_')]
class RegistrationController extends AbstractController
{
    #[Route('/user', name: 'user')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $user->setRoles(['ROLE_USER']);
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('login');
        }

        return $this->renderForm('user/new.html.twig', [
            'form' => $form,
            'user' => $user,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/artist', name: 'artist')]
    public function add(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, ProfilPictureUploader $pictureUploader): Response
    {
        $artist = new Artist();
        $form = $this->createForm(AdminArtistType::class, $artist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $pictureFile */
            $pictureFile = $form->get('profilPicture')->getData();
            $pictureFileName = $pictureUploader->upload($pictureFile);
            $artist->setProfilPicture($pictureFileName);

            $artist->setPassword(
                $userPasswordHasher->hashPassword(
                    $artist,
                    $form->get('password')->getData()
                )
            );
            $artist->setRoles(["ROLE_ARTIST"]);
            $entityManager->persist($artist);
            $entityManager->flush();
            return $this->redirectToRoute('artist_showAll', [], Response::HTTP_SEE_OTHER);

        }
        return $this->renderForm('admin/adminArtistType.html.twig', [
            'form' => $form,
            'artist' => $artist
        ]);
    }
}
