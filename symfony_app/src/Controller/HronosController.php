<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\RegTrans;
use App\Entity\Budget;
use Symfony\Component\Validator\Constraints\DateTime;
use App\Vendor\Hronos\Hronos;
use App\Vendor\TeoBudget\TeoBudget;

class HronosController extends AbstractController
{
    /**
     * @Route("/hronos")
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

        return $this->render('hronos/index.html.twig', [
            'user' => $user,
            'hronos' => $hronos,
        ]);
    }
}
