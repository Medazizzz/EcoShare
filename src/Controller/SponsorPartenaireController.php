<?php

namespace App\Controller;

use App\Entity\SponsorPartenaire;
use App\Form\SponsorPartenaireType;
use App\Repository\SponsorPartenaireRepository;
use App\Service\CloudinaryUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/sponsor-partenaire')]
class SponsorPartenaireController extends AbstractController
{
    #[Route('/', name: 'app_sponsor_partenaire_index', methods: ['GET'])]
    public function index(SponsorPartenaireRepository $repo): Response
    {
        return $this->render('admin/sponsor_partenaire/index.html.twig', [
            'sponsors' => $repo->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_sponsor_partenaire_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em, CloudinaryUploader $uploader, MailerInterface $mailer, #[Autowire('%env(APP_NOTIFICATION_EMAIL)%')] string $notificationEmail): Response
    {
        $sponsor = new SponsorPartenaire();
        $form = $this->createForm(SponsorPartenaireType::class, $sponsor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $logoFile = $form->get('logoFile')->getData();
            if ($logoFile) {
                $logoUrl = $uploader->uploadSponsorLogo($logoFile);
                $sponsor->setLogo($logoUrl);
            }

            $em->persist($sponsor);
            $em->flush();

try {
    $to = $sponsor->getEmail() ?: $notificationEmail;

    if ($to) {
        $email = (new Email())
            ->from($notificationEmail ?: $to)
            ->to($to)
            ->subject(sprintf('Nouveau sponsor / partenaire : %s', $sponsor->getNom()))
            ->text(sprintf(
                "Bonjour,\n\nLe sponsor / partenaire \"%s\" vient d'être ajouté sur EcoShare en tant que %s.\n\nBienvenue à notre nouveau partenaire !\n\n— L'équipe EcoShare",
                $sponsor->getNom(),
                $sponsor->getType()
            ));

        if ($notificationEmail && $notificationEmail !== $to) {
            $email->addBcc($notificationEmail);
        }

        $mailer->send($email);
    }
} catch (\Throwable $e) {
    $this->addFlash('warning', 'Sponsor créé, mais l\'email de notification n\'a pas pu être envoyé.');
}

            $this->addFlash('success', 'Sponsor / partenaire créé avec succès.');

            return $this->redirectToRoute('app_sponsor_partenaire_index');
        }

        return $this->render('admin/sponsor_partenaire/new.html.twig', [
            'sponsor' => $sponsor,
            'form'    => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_sponsor_partenaire_show', methods: ['GET'])]
    public function show(SponsorPartenaire $sponsor): Response
    {
        return $this->render('admin/sponsor_partenaire/show.html.twig', [
            'sponsor' => $sponsor,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_sponsor_partenaire_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SponsorPartenaire $sponsor, EntityManagerInterface $em, CloudinaryUploader $uploader): Response
    {
        $form = $this->createForm(SponsorPartenaireType::class, $sponsor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $logoFile = $form->get('logoFile')->getData();
            if ($logoFile) {
                $logoUrl = $uploader->uploadSponsorLogo($logoFile);
                $sponsor->setLogo($logoUrl);
            }

            $em->flush();
            $this->addFlash('success', 'Sponsor / partenaire mis à jour.');

            return $this->redirectToRoute('app_sponsor_partenaire_index');
        }

        return $this->render('admin/sponsor_partenaire/edit.html.twig', [
            'sponsor' => $sponsor,
            'form'    => $form,
        ]);
    }


    #[Route('/{id}/favori', name: 'app_sponsor_partenaire_toggle_favori', methods: ['POST'])]
    public function toggleFavori(Request $request, SponsorPartenaire $sponsor, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('favori'.$sponsor->getId(), $request->request->get('_token'))) {
            $sponsor->setFavori(!$sponsor->isFavori());
            $em->flush();

            $this->addFlash(
                'success',
                $sponsor->isFavori()
                    ? 'Sponsor / partenaire ajouté aux favoris.'
                    : 'Sponsor / partenaire retiré des favoris.'
            );
        }

        return $this->redirectToRoute('app_sponsors_page');
    }

    #[Route('/{id}', name: 'app_sponsor_partenaire_delete', methods: ['POST'])]
    public function delete(Request $request, SponsorPartenaire $sponsor, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sponsor->getId(), $request->request->get('_token'))) {
            $em->remove($sponsor);
            $em->flush();
            $this->addFlash('success', 'Sponsor / partenaire supprimé.');
        }

        return $this->redirectToRoute('app_sponsor_partenaire_index');
    }
}
