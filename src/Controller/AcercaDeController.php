<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AcercaDeController extends AbstractController
{
    #[Route('/acerca/de', name: 'app_about')]
    public function index(): Response
    {
        return $this->render('acerca_de/index.html.twig', [
            'controller_name' => 'AcercaDeController',
        ]);
    }
}
