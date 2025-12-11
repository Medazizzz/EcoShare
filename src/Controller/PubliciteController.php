<?php

namespace App\Controller;

use App\Entity\Publicite;
use App\Form\PubliciteType;
use App\Repository\PubliciteRepository;
use App\Service\CloudinaryUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

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
    public function new(Request $request, EntityManagerInterface $em, CloudinaryUploader $uploader, MailerInterface $mailer, #[Autowire('%env(APP_PUBLICITE_NOTIFICATION_EMAIL)%')] string $publiciteNotificationEmail): Response
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

            $em->persist($publicite);
            $em->flush();

            try {
                if ($publiciteNotificationEmail) {
                    $email = (new Email())
                        ->from($publiciteNotificationEmail)
                        ->to($publiciteNotificationEmail)
                        ->subject(sprintf('Nouvelle publicité créée : #%d', $publicite->getId()))
                        ->text(sprintf(
                            "Une nouvelle publicité a été créée.\n\nID: %d\nDescription: %s\nSponsor / partenaire: %s\nLien: %s",
                            $publicite->getId(),
                            (string) $publicite->getDescription(),
                            $publicite->getSponsorPartenaire() ? $publicite->getSponsorPartenaire()->getNom() : 'Aucun',
                            (string) $publicite->getLien()
                        ));

                    $mailer->send($email);
                }
            } catch (\Throwable $e) {
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
    public function show(Publicite $publicite): Response
    {
        return $this->render('admin/publicite/show.html.twig', [
            'publicite' => $publicite,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_publicite_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Publicite $publicite, EntityManagerInterface $em, CloudinaryUploader $uploader, MailerInterface $mailer, #[Autowire('%env(APP_PUBLICITE_NOTIFICATION_EMAIL)%')] string $publiciteNotificationEmail): Response
    {
        $form = $this->createForm(PubliciteType::class, $publicite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('imageFile')->getData();
            if ($imageFile) {
                $imageUrl = $uploader->uploadPubliciteImage($imageFile);
                $publicite->setImage($imageUrl);
            }

            $em->flush();

            try {
                if ($publiciteNotificationEmail) {
                    $email = (new Email())
                        ->from($publiciteNotificationEmail)
                        ->to($publiciteNotificationEmail)
                        ->subject(sprintf('Publicité mise à jour : #%d', $publicite->getId()))
                        ->text(sprintf(
                            "Une publicité a été modifiée.\n\nID: %d\nDescription: %s\nSponsor / partenaire: %s\nLien: %s",
                            $publicite->getId(),
                            (string) $publicite->getDescription(),
                            $publicite->getSponsorPartenaire() ? $publicite->getSponsorPartenaire()->getNom() : 'Aucun',
                            (string) $publicite->getLien()
                        ));

                    $mailer->send($email);
                }
            } catch (\Throwable $e) {
                $this->addFlash('warning', "Publicité mise à jour, mais l'email de notification n'a pas pu être envoyé.");
            }

            $this->addFlash('success', 'Publicité mise à jour.');


            return $this->redirectToRoute('app_publicite_index');
        }

        return $this->render('admin/publicite/edit.html.twig', [
            'publicite' => $publicite,
            'form'      => $form,
        ]);
    }



#[Route('/{id}/favori', name: 'app_publicite_toggle_favori', methods: ['POST'])]
public function toggleFavori(Request $request, Publicite $publicite, EntityManagerInterface $em): Response
{
    if ($this->isCsrfTokenValid('favori'.$publicite->getId(), $request->request->get('_token'))) {
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
    public function delete(Request $request, Publicite $publicite, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$publicite->getId(), $request->request->get('_token'))) {
            $em->remove($publicite);
            $em->flush();
            $this->addFlash('success', 'Publicité supprimée.');
        }

        return $this->redirectToRoute('app_publicite_index');
    }
}
