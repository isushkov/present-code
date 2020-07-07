<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\RegTrans;
use App\Entity\Budget;
use Symfony\Component\Validator\Constraints\DateTime;
use App\Vendor\Hronos\Hronos;
use App\Vendor\TeoBudget\TeoBudget;

class HomeController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index()
    {
        $user = $this->getUser();

        $budget = $this->getDoctrine()
            ->getRepository(Budget::class)
            ->findOneBy(['user_id' => $user->getId()]);

        if (!$budget) {
            return $this->render('start/index.html.twig', [
                'user' => $user,
            ]);
        }

        $regTrans = $this->getDoctrine()
            ->getRepository(RegTrans::class)
            ->findBy(['user_id' => $user->getId()]);

        $hronos = new Hronos($budget, $regTrans);
        $teoBudget = new TeoBudget($regTrans);

        return $this->render('home/index.html.twig', [
            'user' => $user,
            'budget' => $budget,
            'hronos' => $hronos,
            'teoBudget' => $teoBudget,
        ]);
    }
}
