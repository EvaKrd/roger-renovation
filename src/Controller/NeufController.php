<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NeufController extends AbstractController
{
    #[Route('/neuf', name: 'app_neuf')]
    public function index(): Response
    {
        return $this->render('neuf/index.html.twig', [
            'controller_name' => 'NeufController',
        ]);
    }
}
