<?php

namespace App\Controller;

use App\Entity\Cliente;
use App\Form\ClienteType;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_USER')]
class ClienteController extends AbstractController {

    private EntityManagerInterface $em;
    private EntityRepository $cr;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
        $this->cr = $this->em->getRepository(Cliente::class);
    }

    #[Route('/cliente', name: 'app_cliente')]
    public function index(): Response {
        $clientes = $this->cr->findAll();

        return $this->render('cliente/index.html.twig', [
                    'clientes' => $clientes
        ]);
    }

    #[Route('/cliente/nuevo', name: 'app_cliente_new')]
    public function new(Request $request): Response {
        $cliente = new Cliente();
        $form = $this->createForm(ClienteType::class, $cliente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($cliente);

            $this->em->flush();

            $this->addFlash('success', 'Se creo el cliente correctamente.');
            return $this->redirectToRoute('app_cliente');
        }

        return $this->render('cliente/new.html.twig', [
                    'form' => $form->createView()
        ]);
    }

    #[Route('/cliente/editar/{id}', name: 'app_cliente_edit')]
    public function edit(int $id, Request $request): Response {
        $cliente = $this->cr->find($id);

        if (is_null($cliente))
            throw new AccessDeniedHttpException();

        $form = $this->createForm(ClienteType::class, $cliente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();

            $this->addFlash('success', 'Se edito el cliente correctamente.');

            return $this->redirectToRoute('app_cliente');
        }

        return $this->render('cliente/new.html.twig', [
                    'form' => $form->createView()
        ]);
    }

    #[Route('/cliente/delete/{id}', name: 'app_cliente_delete', methods: ['GET', 'HEAD'])]
    public function delete(int $id): Response {

        if ($id < 1)
            throw new AccessDeniedHttpException();

        $cliente = $this->cr->find($id);

        return $this->render('cliente/delete.html.twig', [
                    'cliente' => $cliente
        ]);
    }

    #[Route('/cliente/delete', name: 'app_cliente_dodelete', methods: ['DELETE'])]
    public function doDelete(Request $request): Response {

        $submittedToken = $request->request->get('_token');

        if (!$this->isCsrfTokenValid('borrarcosa', $submittedToken)) {
            throw new AccessDeniedHttpException();
        }

        $id = $request->get('id');

        if (is_numeric($id)) {
            $id = intval($id);
            if ($id < 1) {
                throw new AccessDeniedHttpException();
            }
        } else {
            throw new AccessDeniedHttpException();
        }

        $cliente = $this->cr->find($id);

        $this->em->remove($cliente);

        try {
            $this->em->flush();
            $this->addFlash('success', 'Se eliminó el cliente correctamente.');
        } catch (ForeignKeyConstraintViolationException $e) {
            $this->addFlash('error', 'No se puede eliminar el cliente. Ya se le ha vendido.');
        }

        return $this->redirectToRoute('app_cliente');
    }

}
