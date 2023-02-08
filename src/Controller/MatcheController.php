<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Matche;
use App\Entity\Player;

class MatcheController extends AbstractController
{
    #[Route('/matche', name: 'app_matche_create')]
    public function create(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $playerRepository = $doctrine->getRepository(Player::class);

        $players = $playerRepository->findAll();
        shuffle($players);
        $player1 = $players[0];
        $player2 = $players[1];

        $matche = new Matche();
        $matche->setPlayer1($player1);
        $matche->setPlayer2($player2);

        $entityManager->persist($matche);
        $entityManager->flush();

        return $this->redirectToRoute('app_home');
    }

    #[Route('/matche/{id}', name: 'app_matche_show')]
    public function show(ManagerRegistry $doctrine, int $id): Response
    {
        $matcheRepository = $doctrine->getRepository(Matche::class);

        $matche = $matcheRepository->find($id);

        return $this->render('matche/show.html.twig', [
            'matche' => $matche,
        ]);
    }

    #[Route('/paris/{id}', name: 'app_matche_bet')]
    public function bet(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();

        $matcheRepository = $doctrine->getRepository(Matche::class);

        $matche = $matcheRepository->find($id);

        // dd($matche);

        return $this->render('matche/bet.html.twig', [
            'matche' => $matche,
        ]);
    }
}
