<?php

namespace App\Controller;

use App\Entity\ArtCard;
use App\Entity\User;
use App\Form\ArtCardType;
use App\Repository\ArtCardRepository;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use function PHPUnit\Framework\isInstanceOf;
use function PHPUnit\Framework\isTrue;


#[Route('/artcard', name: 'artCard_')]
class ArtCardController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ArtCardRepository $artCardRepository): Response
    {
        $artCards = $artCardRepository->findBy(['pending' => true]);

        return $this->render('artCard/index.html.twig', [
            'artCards' => $artCards
        ]);
    }

    #[Route('/new', name: 'new')]
    #[Security("is_granted('ROLE_ADMIN')")]
    public function new(Request $request, ArtCardRepository $artCardRepository): Response
    {
        $artCard = new ArtCard();
        $form = $this->createForm(ArtCardType::class, $artCard);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $artCard->setUser($this->getUser());
            $artCard->setPending(false);
            $artCardRepository->save($artCard, true);

            return $this->redirectToRoute('artCard_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('artCard/new.html.twig', [
            'form' => $form,
            'user' => $artCard,
        ]);
    }

    #[Security("is_granted('ROLE_ADMIN')")]
    #[Route('/edit/{id}', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(ArtCard $artCard, Request $request, ArtCardRepository $artCardRepository): Response
    {
        $form = $this->createForm(ArtCardType::class, $artCard);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $artCardRepository->save($artCard, true);

            return $this->redirectToRoute('artCard_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('artCard/edit.html.twig', [
            'artCard' => $artCard,
            'form' => $form,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, ArtCard $artCard, ArtCardRepository $artCardRepository): Response
    {
        if (is_string($request->request->get('_token')) || is_null($request->request->get('_token'))) {
            if ($this->isCsrfTokenValid('_delete' . $artCard->getId(), $request->request->get('_token'))) {
                $artCardRepository->remove($artCard, true);
            } else {
                throw new Exception(message: 'token should be string or null');
            }
        }
        return $this->redirectToRoute('artCard_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/admin/pending', name: 'pending')]
    public function pending(ArtCardRepository $artCardRepository): Response
    {
        $artCards = $artCardRepository->findBy(['pending' => 0]);

        return $this->render('artCard/pending.html.twig', [
            'artCards' => $artCards
        ]);
    }
}