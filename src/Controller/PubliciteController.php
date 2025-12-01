<?php

namespace App\Controller;

use App\Entity\Publicite;
use App\Form\PubliciteType;
use App\Repository\PubliciteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/publicite')]
class PubliciteController extends AbstractController
{
    #[Route('/', name: 'app_publicite_index', methods: ['GET'])]
    public function index(PubliciteRepository $repository): Response
    {
        return $this->render('admin/publicite/index.html.twig', [
            'publicites' => $repository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_publicite_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $publicite = new Publicite();
        $form = $this->createForm(PubliciteType::class, $publicite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($publicite);
            $em->flush();

            return $this->redirectToRoute('app_publicite_index');
        }

        return $this->render('admin/publicite/new.html.twig', [
            'publicite' => $publicite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_publicite_show', methods: ['GET'])]
    public function show(Publicite $publicite): Response
    {
        return $this->render('admin/publicite/show.html.twig', [
            'publicite' => $publicite,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_publicite_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Publicite $publicite, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(PubliciteType::class, $publicite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('app_publicite_index');
        }

        return $this->render('admin/publicite/edit.html.twig', [
            'publicite' => $publicite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_publicite_delete', methods: ['POST'])]
    public function delete(Request $request, Publicite $publicite, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$publicite->getId(), $request->request->get('_token'))) {
            $em->remove($publicite);
            $em->flush();
        }

        return $this->redirectToRoute('app_publicite_index');
    }
}
