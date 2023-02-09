<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use App\Entity\Matche;
use App\Entity\Player;
use App\Entity\Score;
use App\Entity\User;

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
    public function bet(ManagerRegistry $doctrine, Request $request, int $id): Response
    {
        $entityManager = $doctrine->getManager();

        $matcheRepository = $doctrine->getRepository(Matche::class);
        $matche = $matcheRepository->find($id);

        $formVictory = $this->createFormBuilder()
            ->add('player', ChoiceType::class, [
                'label' => 'Choisir l\'équipe',
                'choices' => [
                    $matche->getPlayer1()->getFirstName() . ' ' . $matche->getPlayer1()->getLastName() => $matche->getPlayer1()->getId(),
                    $matche->getPlayer2()->getFirstName() . ' ' . $matche->getPlayer2()->getLastName() => $matche->getPlayer2()->getId(),
                ],
            ])
            ->add('amount', IntegerType::class, ['label' => 'Montant'])
            ->add('save', SubmitType::class, ['label' => 'Parier'])
            ->getForm();

        $formVictory->handleRequest($request);

        if ($formVictory->isSubmitted() && $formVictory->isValid()) {
            $data = $formVictory->getData();
            $session = $request->getSession();

            if ($session->get('user')->getWallet() >= $data['amount']) {
                $userRepository = $doctrine->getRepository(User::class);

                $userId = $session->get('user')->getId();
                $user = $userRepository->find($userId);

                $randSet1 = rand(0, 1);
                $randSet2 = rand(0, 1);

                $scorePlayer1 = new Score();
                $scorePlayer1->setMatche($matche);
                $scorePlayer1->setPlayer($matche->getPlayer1());
                $scorePlayer1->setSet1($randSet1);
                $scorePlayer1->setSet2($randSet2);

                $scorePlayer2 = new Score();
                $scorePlayer2->setMatche($matche);
                $scorePlayer2->setPlayer($matche->getPlayer2());
                if ($randSet1 == 0) {
                    $scorePlayer2->setSet1(1);
                } else {
                    $scorePlayer2->setSet1(0);
                }
                if ($randSet2 == 0) {
                    $scorePlayer2->setSet2(1);
                } else {
                    $scorePlayer2->setSet2(0);
                }

                if ($data['player'] == $matche->getPlayer1()->getId()) {
                    if ($randSet1 == 1 && $randSet2 == 1) {
                        $user->setWallet($user->getWallet() + $data['amount']);
                        $session->set('user', $user);
                    } elseif ($randSet1 != $randSet2) {
                        $user->setWallet($user->getWallet());
                        $session->set('user', $user);
                    } else {
                        $user->setWallet($user->getWallet() - $data['amount']);
                        $session->set('user', $user);
                    }
                } else if ($data['player'] == $matche->getPlayer2()->getId()) {
                    if ($randSet1 == 1 && $randSet2 == 1) {
                        $user->setWallet($user->getWallet() - $data['amount']);
                        $session->set('user', $user);
                    } elseif ($randSet1 != $randSet2) {
                        $user->setWallet($user->getWallet());
                        $session->set('user', $user);
                    } else {
                        $user->setWallet($user->getWallet() + $data['amount']);
                        $session->set('user', $user);
                    }
                }

                $entityManager->persist($scorePlayer1);
                $entityManager->persist($scorePlayer2);
                $entityManager->persist($user);
                $entityManager->flush();

                return $this->redirectToRoute('app_home');
            }
        }

        return $this->render('matche/bet.html.twig', [
            'matche' => $matche,
            'formVictory' => $formVictory->createView(),
        ]);
    }
}
