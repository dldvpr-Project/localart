<?php

namespace App\Controller;

use App\Entity\Artist;
use App\Form\ArtistModifyType;
use Exception;
use App\Entity\User;
use App\Form\UserModifyType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/artist', name: 'artist_')]
class ArtistController extends AbstractController
{
    #[Route('/edit/{id}', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, UserRepository $userRepository, Artist $artist): Response
    {
        $form = $this->createForm(ArtistModifyType::class, $artist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $userRepository->save($artist, true);
            return $this->redirectToRoute('user_index');
        }

        return $this->renderForm('artist/edit.html.twig', [
            'form' => $form,
            'user' => $artist
        ]);
    }
}
