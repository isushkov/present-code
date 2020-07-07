<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\RegTrans;
use App\Entity\Budget;

use Symfony\Component\HttpFoundation\Request;

class AjaxController extends AbstractController
{
    /**
     * @Route("/ajax/add-transaction")
     */
    public function addTrans(Request $request)
    {
        $req = $request->request->all();

        $newItem = new RegTrans();
        $newItem->setTypeTransaction($req['type'])
            ->setCyclicity($req['cyclicity'])
            ->setDay($req['day'])
            ->setAmount($req['amount'])
            ->setDescription($req['description'])
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime())
            ->setUserId($this->getUser()->getId())
            ->setShowOnHomePage($req['show-on-homepage']);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($newItem);
        $entityManager->flush();

        return $this->json($request->request->all());
    }

    /**
     * @Route("/ajax/remove-transaction")
     */
    public function removeTrans(Request $request)
    {
        $req = $request->request->all();

        $item = $this->getDoctrine()
            ->getRepository(RegTrans::class)
            ->find($req['id']);
        if (!$item) {
            throw $this->createNotFoundException('No item found for id '.$id);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($item);
        $entityManager->flush();

        return $this->json(true);
    }

    /**
     * @Route("/ajax/edit-budget")
     */
    public function editBudget(Request $request)
    {
        $req = $request->request->all();

        if (!isset($req['tih']) || !isset($req['hl'])) {
            return $this->json($req); // @todo
        }

        $entityManager = $this->getDoctrine()->getManager();
        $budget = $entityManager->getRepository(Budget::class)
            ->findOneBy(['user_id' => $this->getUser()->getId()]);

        if (!$budget) {
            $newItem = new Budget();
            $newItem->setUserId($this->getUser()->getId())
                ->setTih($req['tih'])
                ->setHl(0)
                ->setCreatedAt(new \DateTime())
                ->setUpdatedAt(new \DateTime());
            $entityManager->persist($newItem);
        } else {
            $budget->setTih($req['tih'])
                ->setHl($req['hl'])
                ->setUpdatedAt(new \DateTime());
        }

        $entityManager->flush();

        return $this->json(true);
    }
}
