<?php

namespace App\Controller\Admin;

use App\Entity\Pictures;
use App\Form\PicturesType;
use App\Service\PicturesService;
use App\Repository\PicturesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Symfony\Component\HttpFoundation\RedirectResponse;

#[Route('/admin', name: 'admin_pictures_')]
class PicturesController extends AbstractController
{
    #[Route('/pictures', name: 'home')]
    public function index(PicturesRepository $picturesRepository): Response
    {
        $pictures = $picturesRepository->findAll();
        return $this->render('admin/pictures/index.html.twig', [
            'controller_name' => 'PicturesController',
            'pictures' => $pictures,
        ]);
    }

    #[Route('/add', name: 'add')]
    public function addPictures(Request $request, CacheInterface $cache, PersistenceManagerRegistry $doctrine)
    {
        $picture = new Pictures;
        $form = $this-> createForm(PicturesType::class, $picture);   
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $doctrine->getManager();
            $em->persist($picture);
            $em->flush();

            $cache->delete('pictures_list');

            return $this->redirectToRoute('admin_pictures_home');
        }
        return $this->render('admin/pictures/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/edit/{id}', name: 'edit')]
    public function EditPicture(Pictures $picture, Request $request, CacheInterface $cache,  PersistenceManagerRegistry $doctrine,  PicturesService $picturesService)
    {
        $form = $this->createForm(PicturesType::class, $picture);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            // $file_name = $form->get('file_name')->getData();

            $em = $doctrine->getManager();
            $em->persist($picture);
            $em->flush();

            // On supprime le cache
            $cache->delete('pictures_list');

            return $this->redirectToRoute('admin_pictures_home');
        }

        return $this->render('admin/pictures/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Pictures $picture, PersistenceManagerRegistry $doctrine):RedirectResponse
    {

        $em = $doctrine->getManager();
        $em->remove($picture);
        $em->flush();

        $this->addFlash('message', 'Photo supprimée avec succès');
        return $this->redirectToRoute('admin_pictures_home');
    }

}
