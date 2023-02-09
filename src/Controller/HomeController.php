<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Matche;
use App\Repository\MatcheRepository;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(MatcheRepository $matcheRepository): Response
    {
        $matchesWithoutScore = $matcheRepository->findMatchesWithoutScore();

        return $this->render('home/index.html.twig', [
            'matches' => $matchesWithoutScore,
        ]);
    }
}
