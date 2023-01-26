<?php

namespace App\Controller\Admin;

use App\Entity\PictureDescription;
use App\Form\PictureDescriptionType;
use App\Repository\PictureDescriptionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

#[Route('/admin', name: 'admin_descriptions_')]
class PictureDescriptionController extends AbstractController
{
    #[Route('/descriptions', name: 'home')]
    public function index(PictureDescriptionRepository $pictureDescriptionRepository): Response
    {
       $descriptions = $pictureDescriptionRepository->findAll();
        return $this->render('admin/descriptions/index.html.twig', [
            'controller_name' => 'PictureDescriptionController',
            'descriptions' => $descriptions,
        ]);
    }

    #[Route('/addDescription', name: 'addDescription')]
    public function addDescriptions(Request $request, CacheInterface $cache, PersistenceManagerRegistry $doctrine)
    {
        $description = new PictureDescription;
        $form = $this-> createForm(PictureDescriptionType::class, $description);   
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $doctrine->getManager();
            $em->persist($description);
            $em->flush();

            $cache->delete('descriptions_list');

            return $this->redirectToRoute('admin_descriptions_home');
        }
        return $this->render('admin/descriptions/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/edit/{id}', name: 'edit')]
    public function EditPicture(PictureDescription $description, Request $request, CacheInterface $cache,  PersistenceManagerRegistry $doctrine)
    {
        $form = $this->createForm(PictureDescriptionType::class, $description);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            // $file_name = $form->get('file_name')->getData();

            $em = $doctrine->getManager();
            $em->persist($description);
            $em->flush();

            // On supprime le cache
            $cache->delete('descriptions_list');

            return $this->redirectToRoute('admin_descriptions_home');
        }

        return $this->render('admin/descriptions/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(PictureDescription $description, PersistenceManagerRegistry $doctrine):RedirectResponse
    {
        $em = $doctrine->getManager();
        $em->remove($description);
        $em->flush();

        $this->addFlash('message', 'Description supprimée avec succès');
        return $this->redirectToRoute('admin_description_home');
    }
}
