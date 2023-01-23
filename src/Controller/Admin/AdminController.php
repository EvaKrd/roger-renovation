<?php

namespace App\Controller\Admin;

use App\Entity\Picture;
use App\Form\PictureType;
use App\Entity\PictureDescription;
use App\Repository\PictureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;  
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;



#[Route('/admin', name: 'admin')]

class AdminController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/picture/add', name: 'picture_add')]
    public function create( Request $request, PersistenceManagerRegistry $doctrine)
    {
        $picture = new Picture;
        $form = $this->createForm(PictureType::class, $picture);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $doctrine->getManager();
            $em->persist($picture);
            $em->flush();

            return $this->redirectToRoute('admin_home');
        }

        return $this->render('admin/picture/add.html.twig', [
            'form' => $form->createView()
        ]);
    }


}
