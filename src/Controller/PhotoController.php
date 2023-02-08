<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PicturesRepository;
use App\Repository\PictureCategoryRepository;

class PhotoController extends AbstractController
{
    #[Route('/photo', name: 'app_photo', methods: ['GET'])]
    public function index(PicturesRepository $picturesRepository, PictureCategoryRepository $pictureCategoryRepository): Response
    {
        return $this->render    ('photo/index.html.twig', [
            'pictures' => $picturesRepository->findAll(),
            'categories' => $pictureCategoryRepository->findAll(),
        ]);
    }
}
