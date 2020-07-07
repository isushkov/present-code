<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GraphController extends AbstractController
{
    /**
     * @Route("/graph")
     */
    public function index()
    {
        $user = $this->getUser();
        return $this->render('graph/index.html.twig', [
            'user' => $user,
        ]);
    }
}
