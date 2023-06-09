<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SolsController extends AbstractController
{
    #[Route('/sols', name: 'app_sols')]
    public function index(): Response
    {
        return $this->render('sols/index.html.twig', [
            'controller_name' => 'SolsController',
        ]);
    }
}
