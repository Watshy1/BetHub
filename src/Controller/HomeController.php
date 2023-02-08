<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Matche;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $matcheRepository = $doctrine->getRepository(Matche::class);

        $matches = $matcheRepository->findAll();

        return $this->render('home/index.html.twig', [
            'matches' => $matches,
        ]);
    }
}
