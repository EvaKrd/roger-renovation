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
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


// #[Route('/admin', name: 'admin_pictures_')]
class PicturesController extends AbstractController
{
    #[Route('admin/pictures', name: 'admin_pictures_home', methods: ['GET'])]
    public function index(PicturesRepository $picturesRepository): Response
    {
        return $this->render    ('admin/pictures/index.html.twig', [
            'pictures' => $picturesRepository->findAll(),
        ]);
    }


    #[Route('pictures/add', name: 'admin_pictures_add', methods: ['GET', 'POST'])]
    public function addDescriptions(Request $request, PicturesRepository $picturesRepository, SluggerInterface $slugger):Response
    {
        $picture = new Pictures();
        $form = $this-> createForm(PicturesType::class, $picture);   
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $imageFile = $form->get('Filename')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $picture->setFilename($newFilename);
            }
            $picturesRepository->save($picture, true);
            return $this->redirectToRoute('admin_pictures_home', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('admin/pictures/add.html.twig', [
            'form' => $form,
        ]);
    }
    #[Route('pictures/edit/{id}', name: 'admin_pictures_edit',  methods: ['GET', 'POST'])]
    public function EditPicture(Pictures $picture, Request $request, PicturesRepository $picturesRepository): Response
    {
        $form = $this->createForm(PicturesType::class, $picture);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $picturesRepository->save($picture, true);

            return $this->redirectToRoute('admin_pictures_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/pictures/edit.html.twig', [
            'picture' => $picture,
            'form' => $form,
        ]);
    }

    #[Route('pictures/delete/{id}', name: 'admin_pictures_delete', methods: ['POST'])]
    public function delete(Pictures $picture, PicturesRepository $picturesRepository, Request $request):Response
    {
        if ($this->isCsrfTokenValid('delete'.$picture->getId(), $request->request->get('_token'))) {
            $picturesRepository->remove($picture, true);
        }
        return $this->redirectToRoute('admin_pictures_home', [], Response::HTTP_SEE_OTHER);
    }

}
