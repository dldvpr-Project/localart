<?php

namespace App\Controller;

use App\Entity\Artist;
use App\Entity\User;
use App\Form\AdminArtistType;
use App\Form\AdminModifyUserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/admin', name: 'admin_')]
class AdminController extends AbstractController
{
    #[Route('/add/artist', name: 'add_artist', methods: ['GET', 'POST'])]
    public function add(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $artist = new Artist();
        $form = $this->createForm(AdminArtistType::class, $artist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $artist->setPassword(
                $userPasswordHasher->hashPassword(
                    $artist,
                    $form->get('password')->getData()
                )
            );
            $artist->setRoles(["ROLE_ARTIST"]);
            $entityManager->persist($artist);
            $entityManager->flush();
            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);

        }
        return $this->renderForm('admin/adminArtistType.html.twig', [
            'form' => $form,
            'artist' => $artist
        ]);

    }

    #[Route('/edit/{id}', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, UserRepository $userRepository, User $user): Response
    {
        $form = $this->createForm(AdminModifyUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $
            $userRepository->save($user, true);
            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/userModifyType.html.twig', [
            'form' => $form,
            'user' => $user
        ]);
    }

}