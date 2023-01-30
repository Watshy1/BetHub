<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $passwordConfirm = $_POST['passwordConfirm'];
            $difficulty = $_POST['difficulty'];

            if (isset($firstName) && isset($lastName) && isset($email) && isset($difficulty) && $password == $passwordConfirm) {
                $user = new User();
                $user->setCreatedAt(new \DateTimeImmutable());
                $user->setFirstName($firstName);
                $user->setLastName($lastName);
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
            }
        }

        $diffiulties = array_reverse($difficultyRepository->findAll());

        return $this->render('user/create.html.twig', [
            'difficulties' => $diffiulties,
        ]);
    }

    #[Route('/user/login', name: 'app_user_login')]
    public function login(ManagerRegistry $doctrine, Request $request): Response
    {
        $session = $request->getSession();

        $userRepository = $doctrine->getRepository(User::class);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            if (isset($email) && isset($password)) {
                $user = $userRepository->findOneBy(['email' => $email]);

                if ($user && password_verify($password, $user->getPassword())) {
                    $session->set('user', $user);
                    return $this->redirectToRoute('app_home');
                }
            }
        }

        return $this->render('user/login.html.twig');
    }

    #[Route('/user/logout', name: 'app_user_logout')]
    public function logout(Request $request): Response
    {
        $session = $request->getSession();
        $session->remove('user');
        return $this->redirectToRoute('app_home');
    }
}
