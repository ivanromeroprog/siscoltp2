<?php

namespace App\Controller;

use App\Entity\Cliente;
use App\Repository\ClienteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClienteController extends AbstractController
{
    private EntityManagerInterface $em;
    private EntityRepository $cr;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->cr = $this->em->getRepository(Cliente::class);
    }

    #[Route('/cliente', name: 'app_cliente')]
    public function index(): Response
    {
        $clientes = $this->cr->findAll();

        return $this->render('cliente/index.html.twig', [
            'controller_name' => 'ClienteController',
            'clientes' => $clientes
        ]);
    }


    #[Route('/cliente/new', name: 'app_cliente_new')]
    public function new(): Response
    {
        $cliente = new Cliente('32194767', 'Nombre', 'Apellido', '15439547', 'Direccion');

        $this->em->persist($cliente);
        $this->em->flush();

        return new JsonResponse(['sucess' => true]);
    }

    #[Route('/cliente/{id}', name: 'app_cliente_view')]
    public function view($id): Response
    {
        $cliente = $this->cr->find($id);

        return $this->render('cliente/view.html.twig', [
            'controller_name' => 'ClienteController',
            'cliente' => $cliente
        ]);
    }


}
