<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PictureCategoryRepository;
use App\Entity\PictureCategory;
use App\Form\PictureCategoryType;

class PictureCategoryController extends AbstractController
{
    #[Route('/admin/categories', name: 'admin_categories_home', methods: ['GET'])]
    public function index(PictureCategoryRepository $pictureCategoryRepository): Response
    {
        return $this->render('admin/categories/index.html.twig', [
            'categories' => $pictureCategoryRepository->findAll(),
        ]);
    }

    #[Route('categories/add', name: 'admin_categories_add', methods: ['GET', 'POST'])]
    public function addCategories(Request $request, PictureCategoryRepository $pictureCategoryRepository):Response
    {
        $category = new PictureCategory();
        $form = $this-> createForm(PictureCategoryType::class, $category);   
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $pictureCategoryRepository->save($category, true);

            return $this->redirectToRoute('admin_categories_home', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('admin/categories/add.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    #[Route('categories/edit/{id}', name: 'admin_categories_edit',  methods: ['GET', 'POST'])]
    public function EditCategory(PictureCategory $category, Request $request, PictureCategoryRepository $pictureCategoryRepository): Response
    {
        $form = $this->createForm(PictureCategoryType::class, $category);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $pictureCategoryRepository->save($category, true);

            return $this->redirectToRoute('admin_categories_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/categories/edit.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    #[Route('categories/delete/{id}', name: 'admin_categories_delete', methods: ['POST'])]
    public function delete(PictureCategory $category, PictureCategoryRepository $pictureCategoryRepository, Request $request):Response
    {
        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token'))) {
            $pictureCategoryRepository->remove($category, true);
        }
        return $this->redirectToRoute('admin_categories_home', [], Response::HTTP_SEE_OTHER);
    }
}
