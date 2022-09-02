<?php

namespace App\Controller;

use App\Entity\Producto;
use App\Entity\Usuario;
use App\Entity\Venta;
use App\Form\VentaType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[IsGranted('ROLE_USER')]
class VentaController extends AbstractController
{

    private EntityManagerInterface $em;
    private EntityRepository $cr;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->cr = $this->em->getRepository(Venta::class);
    }

    #[Route('/venta', name: 'app_venta')]
    public function index(): Response
    {
        $ventas = $this->cr->findBy([], ['id' => 'DESC']);

        return $this->render('venta/index.html.twig', [
            'ventas' => $ventas
        ]);
    }

    #[Route('/venta/nuevo', name: 'app_venta_new')]
    public function new(Request $request): Response
    {
        $venta = new Venta();
        $venta->setFecha(new DateTime());

        $pr = $this->em->getRepository(Producto::class);
        $productos_stock = $pr->findAllStock();
        $productos_precio = $pr->findAllPrecio();


        $form = $this->createForm(VentaType::class, $venta);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $detalles = $venta->getDetalles();
            $detalles_productos_id = [];
            $total = 0;
            $error = '';

            foreach ($detalles as $k => $detalle) {

                if ($detalles[$k]->getCantidad() < 1) {
                    unset($detalles[$k]);
                } else {

                    $detalles[$k]->setCostoUnitario($detalle->getProducto()->getPrecio());
                    $detalle->getProducto()->setStock($detalle->getProducto()->getStock() - $detalle->getCantidad());
                    $total = $total + ($detalles[$k]->getCostoUnitario() * $detalles[$k]->getCantidad());

                    //Eliminar producto repetido y acumular su cantidad con el detalle ya guardado
                    if (array_key_exists($detalle->getProducto()->getId(), $detalles_productos_id)) {
                        $detalles_productos_id[$detalle->getProducto()->getId()]->setCantidad(
                            $detalles_productos_id[$detalle->getProducto()->getId()]->getCantidad() +
                                $detalle->getCantidad()
                        );

                        unset($detalles[$k]);
                    } else {
                        $detalles_productos_id[$detalle->getProducto()->getId()] = $detalle;
                    }

                    if ($detalle->getProducto()->getStock() < 0) {
                        $error = "No puedes vender tantos/as " . $detalle->getProducto()->getNombre() . ". Revisa tu pedido.";
                        break;
                    }
                }
            }
            if (count($detalles) < 1) {
                $error = "Debe seleccionar un producto para vender.";
            }

            if ($error === '') {

                $venta->setTotal($total);
                $venta->setEstado('Normal');
                $venta->setUsuario($this->getUser());

                $this->em->persist($venta);
                $this->em->flush();

                $this->addFlash('success', 'Se realizó la venta correctamente. Puede <a href="' . $this->generateUrl('app_venta_view', ['id' => $venta->getId(), 'print' => 'print']) . '" target="_blank">imprimir el remito aquí</a>.');

                return $this->redirectToRoute('app_venta');
            } else {
                $this->addFlash('error', $error);
            }
        }

        return $this->render('venta/new.html.twig', [
            'form' => $form->createView(),
            'productos_stock' => json_encode($productos_stock),
            'productos_precio' => json_encode($productos_precio)
        ]);
    }

    #[Route('/venta/remito/{id}/{print}', name: 'app_venta_view')]
    public function edit(int $id, string $print = 'no'): Response
    {
        $venta = $this->cr->find($id);

        return $this->render('venta/view.html.twig', [
            'venta' => $venta,
            'print' => $print

        ]);
    }

    #[Route('/venta/delete/{id}', name: 'app_venta_delete', methods: ['GET', 'HEAD'])]
    public function delete(int $id): Response
    {

        if ($id < 1)
            throw new AccessDeniedHttpException();

        $venta = $this->cr->find($id);

        return $this->render('venta/delete.html.twig', [
            'venta' => $venta
        ]);
    }

    #[Route('/venta/delete', name: 'app_venta_dodelete', methods: ['DELETE'])]
    public function doDelete(Request $request): Response
    {

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

        $venta = $this->cr->find($id);
        if ($venta->getEstado() == 'Anulado') {
            throw new AccessDeniedHttpException();
        }

        $detalles = $venta->getDetalles();

        foreach ($detalles as $k => $detalle) {
            $p = $detalle->getProducto();
            $p->setStock($p->getStock() + $detalle->getCantidad());
            $this->em->persist($p);
        }

        $venta->setEstado('Anulada');

        $this->em->flush();

        $this->addFlash('success', 'Se anuló la venta correctamente.');

        return $this->redirectToRoute('app_venta');
    }
}
