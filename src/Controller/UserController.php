<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\User;
use App\Entity\Difficulty;

class UserController extends AbstractController
{
    #[Route('/user/create', name: 'app_user_create')]
    public function create(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $difficultyRepository = $doctrine->getRepository(Difficulty::class);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $passwordConfirm = $_POST['passwordConfirm'];
            $difficulty = $_POST['difficulty'];

            if ($password == $passwordConfirm) {
                $user = new User();
                $user->setCreatedAt(new \DateTimeImmutable());
                $user->setFirstName($username);
                $user->setLastName($username);
                $user->setEmail($email);
                $user->setPassword(password_hash($password, PASSWORD_DEFAULT));
                $user->setDifficulty($difficultyRepository->find($difficulty));

                if ($difficulty == $difficultyRepository->find(1)->getId()) {
                    $user->setWallet(1000);
                } else if ($difficulty == $difficultyRepository->find(2)->getId()) {
                    $user->setWallet(300);
                } else if ($difficulty == $difficultyRepository->find(3)->getId()) {
                    $user->setWallet(100);
                }

                $entityManager->persist($user);
                $entityManager->flush();
            } else {
                echo 'Passwords do not match';
            }
        }

        $diffiulties = array_reverse($difficultyRepository->findAll());

        return $this->render('user/create.html.twig', [
            'difficulties' => $diffiulties,
        ]);
    }
}
