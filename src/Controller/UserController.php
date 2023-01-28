<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\User;

class UserController extends AbstractController
{
    #[Route('/user/create', name: 'app_user_create')]
    public function create(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $passwordConfirm = $_POST['passwordConfirm'];

            if ($password == $passwordConfirm) {
                $user = new User();
                $user->setFirstName($username);
                $user->setLastName($username);
                $user->setEmail($email);
                $user->setPassword(password_hash($password, PASSWORD_DEFAULT));

                $entityManager->persist($user);
                $entityManager->flush();
            } else {
                echo 'Passwords do not match';
            }
        }

        return $this->render('user/create.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
