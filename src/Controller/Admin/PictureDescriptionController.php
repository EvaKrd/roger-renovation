<?php

namespace App\Controller\Admin;

use App\Entity\PictureDescription;
use App\Form\PictureDescriptionType;
use App\Repository\PictureDescriptionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


// #[Route('/admin', name: 'admin_descriptions_')]
class PictureDescriptionController extends AbstractController
{
    #[Route('admin/descriptions', name: 'admin_descriptions_home', methods: ['GET'])]
    public function index(PictureDescriptionRepository $pictureDescriptionRepository): Response
    {
        return $this->render    ('admin/descriptions/index.html.twig', [
            'descriptions' => $pictureDescriptionRepository->findAll(),
        ]);
    }

    #[Route('descriptions/add', name: 'admin_descriptions_add', methods: ['GET', 'POST'])]
    public function addDescriptions(Request $request, PictureDescriptionRepository $pictureDescriptionRepository):Response
    {
        $description = new PictureDescription();
        $form = $this-> createForm(PictureDescriptionType::class, $description);   
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $pictureDescriptionRepository->save($description, true);

            return $this->redirectToRoute('admin_descriptions_home', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('admin/descriptions/add.html.twig', [
            'description' => $description,
            'form' => $form,
        ]);
    }

    #[Route('descriptions/edit/{id}', name: 'admin_descriptions_edit',  methods: ['GET', 'POST'])]
    public function EditPicture(PictureDescription $description, Request $request, PictureDescriptionRepository $pictureDescriptionRepository): Response
    {
        $form = $this->createForm(PictureDescriptionType::class, $description);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $pictureDescriptionRepository->save($description, true);

            return $this->redirectToRoute('admin_descriptions_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/descriptions/edit.html.twig', [
            'description' => $description,
            'form' => $form,
        ]);
    }

    #[Route('descriptions/delete/{id}', name: 'admin_descriptions_delete', methods: ['GET', 'POST'])]
    public function delete(PictureDescription $description, PictureDescriptionRepository $pictureDescriptionRepository, Request $request):Response
    {
        if ($this->isCsrfTokenValid('delete'.$description->getId(), $request->request->get('_token'))) {
            $pictureDescriptionRepository->remove($description, true);
        }
        return $this->redirectToRoute('admin_descriptions_home', [], Response::HTTP_SEE_OTHER);
    }
}
