<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarrelageController extends AbstractController
{
    #[Route('/carrelage', name: 'app_carrelage')]
    public function index(): Response
    {
        return $this->render('carrelage/index.html.twig', [
            'controller_name' => 'CarrelageController',
        ]);
    }
}
