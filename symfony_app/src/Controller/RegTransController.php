<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\RegTrans;
use App\Entity\Budget;

class RegTransController extends AbstractController
{
    /**
     * @Route("/regtrans")
     */
    public function index()
    {
        $user = $this->getUser();

        $budget = $this->getDoctrine()
            ->getRepository(Budget::class)
            ->findOneBy(['user_id' => $user->getId()]);
        $incomes = $this->getDoctrine()
            ->getRepository(RegTrans::class)
            ->findBy([
                'user_id' => $user->getId(),
                'type_transaction' => 'incomes',
            ]);
        $expenses = $this->getDoctrine()
            ->getRepository(RegTrans::class)
            ->findBy([
                'user_id' => $user->getId(),
                'type_transaction' => 'expenses',
            ]);

        return $this->render('regtrans/index.html.twig', [
            'user' => $user,
            'budget' => $budget,
            'incomes' => $incomes,
            'expenses' => $expenses,
        ]);
    }
}
