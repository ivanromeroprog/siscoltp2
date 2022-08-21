<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
Use App\Entity\Usuario;


class UsuarioController extends AbstractController
{
    private EntityManagerInterface $em;
    private EntityRepository $cr;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->cr = $this->em->getRepository(Usuario::class);
    }
    
    #[Route('/usuario', name: 'app_usuario')]
    public function index(): Response
    {
        return $this->render('usuario/index.html.twig', [
            'controller_name' => 'UsuarioController',
        ]);
    }
    
    #[Route('/usuario/nuevo', name: 'app_usuario_new')]
    public function new(): Response
    {
        return $this->render('usuario/new.html.twig', [
            'controller_name' => 'UsuarioController',
        ]);
    }
}
