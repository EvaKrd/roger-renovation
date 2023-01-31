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

// #[Route('/admin', name: 'admin_descriptions_')]
class PictureDescriptionController extends AbstractController
{
    #[Route('admin/descriptions', name: 'admin_descriptions_home', methods: ['GET'])]
    public function index(PictureDescriptionRepository $pictureDescriptionRepository): Response
    {
       $descriptions = $pictureDescriptionRepository->findAll();
        return $this->render('admin/descriptions/index.html.twig', [
            'controller_name' => 'PictureDescriptionController',
            'descriptions' => $descriptions,
        ]);
    }

    #[Route('descriptions/add', name: 'admin_descriptions_add', methods: ['GET', 'POST'])]
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

    #[Route('descriptions/edit/{id}', name: 'admin_descriptions_edit',  methods: ['GET', 'POST'])]
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

    #[Route('descriptions/delete/{id}', name: 'admin_descriptions_delete', methods: ['POST'])]
    public function delete(PictureDescription $description, PersistenceManagerRegistry $doctrine, PictureDescriptionRepository $pictureRepository, Request $request):Response
    {
        if ($this->isCsrfTokenValid('delete'.$description->getId(), $request->request->get('_token'))) {
            $pictureRepository->remove($description, true);
        }
        return $this->redirectToRoute('admin_descriptions_home', [], Response::HTTP_SEE_OTHER);
    }
}
