<?php

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\SpecialBet;
use App\Entity\Matche;
use App\Entity\Player;

use App\Form\SpecialBetType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SpecialBetController extends AbstractController
{

    public function index(Request $request, EntityManagerInterface $em)
    {

        $match = $em->getRepository(Matche::class)->findOneBy(['status' => 'in progress']);


        $player = $em->getRepository(Player::class)->findOneBy(['user' => $this->getUser()]);


        $specialBet = $em->getRepository(SpecialBet::class)->findOneBy(['matche' => $match, 'player' => $player]);


        if (!$specialBet) {
            $specialBet = new SpecialBet();
            $specialBet->setMatche($match);
            $specialBet->setPlayer($player);
        }


        $form = $this->createForm(SpecialBetType::class, $specialBet);


        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($specialBet);
            $em->flush();


            $this->addFlash('success', 'Votre pari spécial a bien été enregistré.');


            return $this->redirectToRoute('home');
        }

        return $this->render('special_bet/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
