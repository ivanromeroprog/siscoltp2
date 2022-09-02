<?php

namespace App\Controller;

use App\Entity\Producto;
use App\Form\ProductoType;
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
class ProductoController extends AbstractController {

    private EntityManagerInterface $em;
    private EntityRepository $cr;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
        $this->cr = $this->em->getRepository(Producto::class);
    }

    #[Route('/producto', name: 'app_producto')]
    public function index(): Response {
        $productos = $this->cr->findAll();

        return $this->render('producto/index.html.twig', [
                    'productos' => $productos
        ]);
    }

    #[Route('/producto/nuevo', name: 'app_producto_new')]
    public function new(Request $request): Response {
        $producto = new Producto();
        $form = $this->createForm(ProductoType::class, $producto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($producto);
            $this->em->flush();

            $this->addFlash('success', 'Se creo el producto correctamente.');

            return $this->redirectToRoute('app_producto');
        }

        return $this->render('producto/new.html.twig', [
                    'form' => $form->createView()
        ]);
    }

    #[Route('/producto/editar/{id}', name: 'app_producto_edit')]
    public function edit(int $id, Request $request): Response {
        $producto = $this->cr->find($id);

        if (is_null($producto))
            throw new AccessDeniedHttpException();

        $form = $this->createForm(ProductoType::class, $producto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();

            $this->addFlash('success', 'Se edito el producto correctamente.');

            return $this->redirectToRoute('app_producto');
        }

        return $this->render('producto/new.html.twig', [
                    'form' => $form->createView()
        ]);
    }
    
    
    #[Route('/producto/ver/{id}', name: 'app_producto_view')]
    public function view(int $id): Response {
        if ($id < 1)
            throw new AccessDeniedHttpException();

        $producto = $this->cr->find($id);

        if (is_null($producto))
            throw new AccessDeniedHttpException();

        $form = $this->createForm(ProductoType::class, $producto, ['view' => true]);

        return $this->render('producto/new.html.twig', [
                    'form' => $form->createView()
        ]);
    }

    #[Route('/producto/delete/{id}', name: 'app_producto_delete', methods: ['GET', 'HEAD'])]
    public function delete(int $id): Response {
        if ($id < 1)
            throw new AccessDeniedHttpException();

        $producto = $this->cr->find($id);

        if (is_null($producto))
            throw new AccessDeniedHttpException();

        $form = $this->createForm(ProductoType::class, $producto, ['view' => true]);

        return $this->render('producto/delete.html.twig', [
                    'producto' => $producto,
                    'form' => $form->createView()
        ]);
    }

    #[Route('/producto/delete', name: 'app_producto_dodelete', methods: ['DELETE'])]
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

        $producto = $this->cr->find($id);

        $this->em->remove($producto);
        try {
            $this->em->flush();
            $this->addFlash('success', 'Se eliminó el producto correctamente.');

        } catch (ForeignKeyConstraintViolationException $e) {
            $this->addFlash('error', 'No se puede eliminar el producto. Ya se ha vendido.');
        }
        return $this->redirectToRoute('app_producto');
    }

}
