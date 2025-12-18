<?php

namespace App\Controller;

use App\Entity\Publicite;
use App\Form\PubliciteType;
use App\Repository\PubliciteRepository;
use App\Service\CloudinaryUploader;
use App\Service\AiDescriptionService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

#[Route('/publicite')]
class PubliciteController extends AbstractController
{
    #[Route('/', name: 'app_publicite_index', methods: ['GET'])]
    public function index(PubliciteRepository $repo): Response
    {
        return $this->render('admin/publicite/index.html.twig', [
            'publicites' => $repo->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_publicite_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $em,
        CloudinaryUploader $uploader,
        MailerInterface $mailer,
        AiDescriptionService $ai
    ): Response
    {
        $publicite = new Publicite();
        $form = $this->createForm(PubliciteType::class, $publicite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('imageFile')->getData();
            if ($imageFile) {
                $imageUrl = $uploader->uploadPubliciteImage($imageFile);
                $publicite->setImage($imageUrl);
            }

            // AI auto-generate description if empty
if (!$publicite->getDescription() || trim($publicite->getDescription()) === '') {
    $context =
        'Lien: ' . ($publicite->getLien() ?? 'N/A') . ', ' .
        'Sponsor/Partenaire: ' . (($publicite->getSponsorPartenaire() && method_exists($publicite->getSponsorPartenaire(), 'getNom')) ? $publicite->getSponsorPartenaire()->getNom() : 'Aucun') . ', ' .
        'Image: ' . ($publicite->getImage() ?? 'N/A');

    $generated = $ai->generate($context);
    $publicite->setDescription($generated);
}

$em->persist($publicite);

            $em->flush();

            
            try {
                $to = (string) $this->getParameter('app.publicite_notification_email');
                $from = (string) $this->getParameter('app.mailer_from');



                $id = (string) $publicite->getId();

                $description = trim((string) ($publicite->getDescription() ?? ''));
                $description = $description !== '' ? $description : 'Aucune description';

                $lien = trim((string) ($publicite->getLien() ?? ''));
                $lien = $lien !== '' ? $lien : 'Aucun';

                $sponsor = $publicite->getSponsorPartenaire();
                $sponsorName = $sponsor ? $sponsor->getNom() : 'Aucun';

                $body =
                    "Nouvelle publicité créée : #{$id}\n"
                    . "================================\n\n"
                    . "Une nouvelle publicité a été créée.\n\n"
                    . "ID: {$id}\n"
                    . "Description: {$description}\n"
                    . "Sponsor / partenaire: {$sponsorName}\n"
                    . "Lien: {$lien}\n";

                $email = (new Email())
                    ->from($from)
                    ->to($to)
                    ->subject("Nouvelle publicité créée : #{$id}")
                    ->text($body);

                $mailer->send($email);
            } catch (\Throwable $e) {
                // Don’t block creation if mail fails
                $this->addFlash('warning', "Publicité créée, mais l'email de notification n'a pas pu être envoyé.");
            }

            $this->addFlash('success', 'Publicité créée avec succès.');
            return $this->redirectToRoute('app_publicite_index');
        }

        return $this->render('admin/publicite/new.html.twig', [
            'publicite' => $publicite,
            'form'      => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_publicite_show', methods: ['GET'])]
    public function show(?Publicite $publicite): Response
    {
        if (!$publicite) {
            $this->addFlash('warning', 'Publicité introuvable.');
            return $this->redirectToRoute('app_publicite_index');
        }

        return $this->render('admin/publicite/show.html.twig', [
            'publicite' => $publicite,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_publicite_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ?Publicite $publicite, EntityManagerInterface $em, CloudinaryUploader $uploader): Response
    {
        if (!$publicite) {
            $this->addFlash('warning', 'Publicité introuvable.');
            return $this->redirectToRoute('app_publicite_index');
        }

        $form = $this->createForm(PubliciteType::class, $publicite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('imageFile')->getData();
            if ($imageFile) {
                $imageUrl = $uploader->uploadPubliciteImage($imageFile);
                $publicite->setImage($imageUrl);
            }

            $em->flush();

            $this->addFlash('success', 'Publicité mise à jour.');
            return $this->redirectToRoute('app_publicite_index');
        }

        return $this->render('admin/publicite/edit.html.twig', [
            'publicite' => $publicite,
            'form'      => $form,
        ]);
    }

    #[Route('/{id}/favori', name: 'app_publicite_toggle_favori', methods: ['POST'])]
    public function toggleFavori(Request $request, ?Publicite $publicite, EntityManagerInterface $em): Response
    {
        if (!$publicite) {
            $this->addFlash('warning', 'Publicité introuvable.');
            return $this->redirectToRoute('app_publicite_index');
        }

        if ($this->isCsrfTokenValid('favori' . $publicite->getId(), $request->request->get('_token'))) {
            $publicite->setFavori(!$publicite->isFavori());
            $em->flush();

            $this->addFlash(
                'success',
                $publicite->isFavori()
                    ? 'Publicité ajoutée aux favoris.'
                    : 'Publicité retirée des favoris.'
            );
        }

        return $this->redirectToRoute('app_publicite_index');
    }

    #[Route('/{id}', name: 'app_publicite_delete', methods: ['POST'])]
    public function delete(Request $request, ?Publicite $publicite, EntityManagerInterface $em): Response
    {
        if (!$publicite) {
            $this->addFlash('warning', 'Publicité introuvable.');
            return $this->redirectToRoute('app_publicite_index');
        }

        if ($this->isCsrfTokenValid('delete' . $publicite->getId(), $request->request->get('_token'))) {
            $em->remove($publicite);
            $em->flush();
            $this->addFlash('success', 'Publicité supprimée.');
        }

        return $this->redirectToRoute('app_publicite_index');
    }
}
