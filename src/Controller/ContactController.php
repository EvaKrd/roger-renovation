<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Email;

class ContactController extends AbstractController
{
     #[Route('/contact', name: 'app_contact')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()&& $form->isValid()){
            $data=$form->getData();
            $email=$data['email'];

            return $this->render('contact/success.index.html.twig', [
                'email' => $email
            ]);
        }else{
            return $this->renderForm('contact/index.html.twig', [
                'controller_name' => 'ContactController',
                'formulaire' => $form
            ]);
        }
    }
}
