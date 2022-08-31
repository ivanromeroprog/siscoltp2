<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Form\UsuarioType;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_USER')]
class UsuarioController extends AbstractController {

    private EntityManagerInterface $em;
    private EntityRepository $ur;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
        $this->ur = $this->em->getRepository(Usuario::class);
    }

    #[Route('/usuario', name: 'app_usuario')]
    public function index(): Response {

        $usuarios = $this->ur->findAll();

        return $this->render('usuario/index.html.twig', [
                    'usuarios' => $usuarios,
        ]);
    }

    #[Route('/usuario/nuevo', name: 'app_usuario_new')]
    public function new(Request $request, UserPasswordHasherInterface $passwordHasher): Response {
        $usuario = new Usuario();
        $form = $this->createForm(UsuarioType::class, $usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $plaintextPassword = $form->get('password')->getData();
            $hashedPassword = $passwordHasher->hashPassword(
                    $usuario,
                    $plaintextPassword
            );
            $usuario->setPassword($hashedPassword);
            $usuario->setRoles(['ROLE_USER']);

            $this->em->persist($usuario);
            $this->em->flush();

            $this->addFlash('success', 'Se creo el usuario correctamente.');

            return $this->redirectToRoute('app_usuario');
        }

        return $this->render('usuario/new.html.twig', [
                    'form' => $form->createView()
        ]);
    }

    #[Route('/usuario/editar/{id}', name: 'app_usuario_edit')]
    public function edit(int $id, Request $request, UserPasswordHasherInterface $passwordHasher): Response {
        $usuario = $this->ur->find($id);

        if (is_null($usuario))
            throw new AccessDeniedHttpException();




        $form = $this->createForm(UsuarioType::class, $usuario, ['required_password' => false]);

        if ($request->isMethod('POST')) {
            $formdata = $request->get($form->getName());

            if ($formdata['password']['first'] === '') {

                unset($formdata['password']);
                $form->submit($formdata, false);
            } else {

                $form->submit($formdata);
                $plaintextPassword = $form->get('password')->getData();
                $hashedPassword = $passwordHasher->hashPassword(
                        $usuario,
                        $plaintextPassword
                );
                $usuario->setPassword($hashedPassword);
            }



            if ($form->isSubmitted() && $form->isValid()) {

                $this->em->flush();

                $this->addFlash('success', 'Se edito el usuario correctamente.');

                return $this->redirectToRoute('app_usuario');
            }
        }


        return $this->render('usuario/new.html.twig', [
                    'form' => $form->createView()
        ]);
    }

    #[Route('/usuario/delete/{id}', name: 'app_usuario_delete', methods: ['GET', 'HEAD'])]
    public function delete(int $id): Response {

        if ($id < 1)
            throw new AccessDeniedHttpException();

        $usuario = $this->ur->find($id);

        return $this->render('usuario/delete.html.twig', [
                    'usuario' => $usuario
        ]);
    }

    #[Route('/usuario/delete', name: 'app_usuario_dodelete', methods: ['DELETE'])]
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

        $usuariologeado = $this->getUser();

        $usuario = $this->ur->find($id);

        if ($usuario->getId() === $usuariologeado->getId()) {
            $this->addFlash('warning', 'No se puede eliminar el usuario logeado actualmente.');

            return $this->redirectToRoute('app_usuario');
        }


        $this->em->remove($usuario);

        try {
            $this->em->flush();
            $this->addFlash('success', 'Se eliminó el usuario correctamente.');
        } catch (ForeignKeyConstraintViolationException $e) {
            $this->addFlash('error', 'No se puede eliminar el usuario, ya ha realizado una venta.');
        }


        return $this->redirectToRoute('app_usuario');
    }

}
