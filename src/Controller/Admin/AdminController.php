<?php

namespace App\Controller\Admin;

use App\Entity\Pictures;
use App\Form\PicturesType;
use App\Entity\PictureDescription;
use App\Form\PictureDescriptionType;
use App\Repository\PicturesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;   
use Symfony\Component\HttpFoundation\Response;  
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;



// #[Route('/admin', name: 'admin_')]

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin_home')]
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    // #[Route('/pictures/add', name: 'pictures_add')]
    // public function create( Request $request, PersistenceManagerRegistry $doctrine)
    // {
    //     $picture = new Pictures;
    //     $form = $this->createForm(PicturesType::class, $picture);
    //     $form->handleRequest($request);

    //     if($form->isSubmitted() && $form->isValid()){
    //         $em = $doctrine->getManager();
    //         $em->persist($picture);
    //         $em->flush();

    //         return $this->redirectToRoute('admin_home');
    //     }

    //     return $this->render('admin/pictures/add.html.twig', [
    //         'form' => $form->createView()
    //     ]);
    // }

    // #[Route('/descriptions/addDescription', name: 'descriptions_addDescription')]
    // public function createDescription( Request $request, PersistenceManagerRegistry $doctrine)
    // {
    //     $description = new PictureDescription;
    //     $form = $this->createForm(PictureDescriptionType::class, $description);
    //     $form->handleRequest($request);

    //     if($form->isSubmitted() && $form->isValid()){
    //         $em = $doctrine->getManager();
    //         $em->persist($description);
    //         $em->flush();

    //         return $this->redirectToRoute('admin_home');
    //     }

    //     return $this->render('admin/descriptions/add.html.twig', [
    //         'form' => $form->createView()
    //     ]);
    // }
    

}
