<?php

namespace App\Controller;

use App\Entity\Artist;
use App\Entity\User;
use App\Form\AdminModifyUserType;
use App\Repository\UserRepository;
use App\Form\AdminModifyArtistType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[IsGranted('ROLE_ADMIN')]
#[Route('/admin', name: 'admin_')]
class AdminController extends AbstractController
{
    #[Route('/user/edit/{id}', name: 'edit_user', methods: ['GET', 'POST'])]
    public function userEdit(Request $request, UserRepository $userRepository, User $user): Response
    {
        $form = $this->createForm(AdminModifyUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $userRepository->save($user, true);

            $this->addFlash('success', 'Modification effectuée avec succès.');

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/userModifyType.html.twig', [
            'form' => $form,
            'user' => $user
        ]);
    }

    #[Route('/artist/edit/{id}', name: 'edit_artist', methods: ['GET', 'POST'])]
    public function artistEdit(Request $request, UserRepository $userRepository, Artist $artist): Response
    {
        $form = $this->createForm(AdminModifyArtistType::class, $artist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $userRepository->save($artist, true);

            $this->addFlash('success', 'Modification effectuée avec succès.');

            return $this->redirectToRoute('artist_showAll', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/artistModifyType.html.twig', [
            'form' => $form,
            'user' => $artist
        ]);
    }
}