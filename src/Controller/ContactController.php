<?php

namespace App\Controller;

use App\Form\ContactFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(): Response
    {
        $form = $this->createForm(ContactFormType::class);

        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'search' => '',
            'form' => $form,
            'titre' => 'Contact'
        ]);
    }
}
