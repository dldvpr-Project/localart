<?php

namespace App\Controller;

use App\Repository\ArtCardRepository;
use App\Repository\ViewRandCardRepository;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function PHPUnit\Framework\isInstanceOf;
use function PHPUnit\Framework\isJson;

class ApiOpenStreetMapController extends AbstractController
{

    #[Route("/home-api", name: 'api_home')]
    public function mapOnIndex(ViewRandCardRepository $viewRandCardRepository, ArtCardRepository $artCardRepository): JsonResponse
    {
        $frontCard = $artCardRepository->findOneBy(['id' => $viewRandCardRepository->findOneBy([])]);
        if ($frontCard === null)
        {
            throw $this->createNotFoundException();
        }
        $data = json_encode(['latitude' => $frontCard->getLatitude(), 'longitude' => $frontCard->getLongitude()], JSON_THROW_ON_ERROR);

        return new JsonResponse($data, 200, [], true);    }
}
