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
class VentaController extends AbstractController {

    private EntityManagerInterface $em;
    private EntityRepository $cr;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
        $this->cr = $this->em->getRepository(Venta::class);
    }

    #[Route('/venta', name: 'app_venta')]
    public function index(): Response {
        $ventas = $this->cr->findAll();

        return $this->render('venta/index.html.twig', [
                    'ventas' => $ventas
        ]);
    }

    #[Route('/venta/nuevo', name: 'app_venta_new')]
    public function new(Request $request): Response {
        $venta = new Venta();
        $venta->setFecha(new DateTime());

        $pr = $this->em->getRepository(Producto::class);
        $productos_stock = $pr->findAllStock();
        //dd($productos_stock);
        //die();
        // dummy code - add some example tags to the task
        // (otherwise, the template will render an empty list of tags)
        //$detalle1 = new DetalleVenta(null,1,10.5,null,$this->em->getRepository(Producto::class)->find(1));
        //$venta->getDetalles()->add($detalle1);
        // end dummy code

        $form = $this->createForm(VentaType::class, $venta);
        $form->handleRequest($request);

        //dd($form);
        // die();

        if ($form->isSubmitted() && $form->isValid()) {

            $detalles = $venta->getDetalles();
            $total = 0;
            $error = '';
            //$prodlist = [];

            foreach ($detalles as $k => $detalle) {
                
                if($detalles[$k]->getCantidad() < 1)
                {
                    unset($detalles[$k]);
                }
                else
                {
                $detalles[$k]->setCostoUnitario($detalle->getProducto()->getPrecio());
                $detalle->getProducto()->setStock($detalle->getProducto()->getStock() - $detalle->getCantidad());
                $total = $total + ($detalles[$k]->getCostoUnitario() * $detalles[$k]->getCantidad());

                if ($detalle->getProducto()->getStock() < 0) {
                    $error = "No puedes vender tantos/as " . $detalle->getProducto()->getNombre() . ". Revisa tu pedido.";
                    break;
                }
                }

                //$prodlist[] = $detalle->getProducto();
            }
            if(count($detalles) < 1){
                $error = "Debe seleccionar un producto para vender.";
            }

            //$usuario = $this->getUser();
            //dd($detalles, $total, $error, $usuario);
            //die();

            if ($error === '') {

                $venta->setTotal($total);
                $venta->setEstado('Normal');
                $venta->setUsuario($this->getUser());

                $this->em->persist($venta);
                $this->em->flush();

                $this->addFlash('success', 'Se creo la venta correctamente.');

                return $this->redirectToRoute('app_venta');
            } else {
                $this->addFlash('error', $error);
            }
        }

        return $this->render('venta/new.html.twig', [
                    'form' => $form->createView(),
                    'productos_stock' => json_encode($productos_stock)
        ]);
    }

    #[Route('/venta/editar/{id}', name: 'app_venta_edit')]
    public function edit(int $id, Request $request): Response {
        $venta = $this->cr->find($id);

        $pr = $this->em->getRepository(Producto::class);
        $productos_stock = $pr->findAllStock();

        if (is_null($venta))
            throw new AccessDeniedHttpException();

        $form = $this->createForm(VentaType::class, $venta);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();

            $this->addFlash('success', 'Se edito el venta correctamente.');

            return $this->redirectToRoute('app_venta');
        }

        return $this->render('venta/new.html.twig', [
                    'form' => $form->createView(),
                    'productos_stock' => json_encode($productos_stock)
        ]);
    }

    #[Route('/venta/delete/{id}', name: 'app_venta_delete', methods: ['GET', 'HEAD'])]
    public function delete(int $id): Response {

        if ($id < 1)
            throw new AccessDeniedHttpException();

        $venta = $this->cr->find($id);

        return $this->render('venta/delete.html.twig', [
                    'venta' => $venta
        ]);
    }

    #[Route('/venta/delete', name: 'app_venta_dodelete', methods: ['DELETE'])]
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

        $venta = $this->cr->find($id);

        $this->em->remove($venta);
        $this->em->flush();

        $this->addFlash('success', 'Se eliminó el venta correctamente.');

        return $this->redirectToRoute('app_venta');
    }

}
