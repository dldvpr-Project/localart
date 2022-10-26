<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user', name: 'user_')]
class UserController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
        ]);
    }

    #[Route('/add', name: 'add')]
    public function add(): Response
    {

        return $this->renderForm('user/add.html.twig', [

        ]);
    }

    #[Route('/edit', name: 'edit')]
    public function edit(): Response
    {

        return $this->renderForm('user/edit.html.twig'[]);
    }

    #[Route('/')]
}
