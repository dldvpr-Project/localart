<?php

namespace App\Controller;

use Exception;
use App\Entity\User;
use App\Form\UserModifyType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/user', name: 'user_')]
class UserController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin', name: 'index')]
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findUserByRole();

        return $this->render('user/index.html.twig', [
            'users' => $users
        ]);
    }

    #[Route('/profil', name: 'show')]
    public function show(UserRepository $userRepository): Response
    {

        if ($this->getUser() === null) {
            return $this->redirectToRoute('artist_showAll');
        }

        /** @var User $user **/
        $user = $this->getUser();
        $userId = $user->getId();

        $user = $userRepository->findOneBy(['id' => $userId]);

        return $this->render('user/profil.html.twig', [
           'user' => $user
        ]);
    }

    #[Route('/modify-profil', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, UserRepository $userRepository): Response
    {
        if ($this->getUser() === null) {
            return $this->redirectToRoute('artist_showAll');
        }

        /** @var User $user */
        $user = $this->getUser();

        $form = $this->createForm(UserModifyType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $userRepository->save($user, true);
            return $this->redirectToRoute('user_show');
        }

        return $this->renderForm('user/edit.html.twig', [
            'form' => $form,
            'user' => $user
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if (is_string($request->request->get('_token')) || is_null($request->request->get('_token'))) {
            if ($this->isCsrfTokenValid('_delete' . $user->getId(), $request->request->get('_token'))) {
                $userRepository->remove($user, true);
            } else {
                throw new Exception(message: 'token should be string or null');
            }
        }
        return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
    }
}
