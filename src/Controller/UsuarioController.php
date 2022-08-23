<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Form\UsuarioType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
    public function edit(int $id, Request $request): Response {
        $usuario = $this->cr->find($id);
        
        if(is_null($usuario))
            throw new AccessDeniedHttpException();
        
        $form = $this->createForm(ClienteType::class, $usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();

            $this->addFlash('success', 'Se edito el usuario correctamente.');

            return $this->redirectToRoute('app_usuario');
        }

        return $this->render('usuario/new.html.twig', [
                    'form' => $form->createView()
        ]);
    }
   

    #[Route('/usuario/delete/{id}', name: 'app_usuario_delete', methods: ['GET', 'HEAD'])]
    public function delete(int $id): Response {

        if ($id < 1)
            throw new AccessDeniedHttpException();

        $usuario = $this->cr->find($id);

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
        
        $usuario = $this->cr->find($id);
        
        $this->em->remove($usuario);
        $this->em->flush();

        $this->addFlash('success', 'Se eliminó el usuario correctamente.');

        return $this->redirectToRoute('app_usuario');
    }
    

}
