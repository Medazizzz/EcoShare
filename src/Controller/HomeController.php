<?php

namespace App\Controller;

use App\Repository\SponsorPartenaireRepository;
use App\Repository\PubliciteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(
        SponsorPartenaireRepository $sponsorPartenaireRepository,
        PubliciteRepository $publiciteRepository
    ): Response {
        $sponsors = $sponsorPartenaireRepository->findAll();
        $publicites = $publiciteRepository->findAll();

        return $this->render('home.html.twig', [
            'sponsors' => $sponsors,
            'publicites' => $publicites,
        ]);
    }

    #[Route('/sponsors-partenaires', name: 'app_sponsors_page')]
    public function sponsorsPage(
        SponsorPartenaireRepository $sponsorPartenaireRepository,
        PubliciteRepository $publiciteRepository
    ): Response {
        $sponsors = $sponsorPartenaireRepository->findAll();
        $publicites = $publiciteRepository->findAll();

        return $this->render('user/sponsors.html.twig', [
            'sponsors' => $sponsors,
            'publicites' => $publicites,
        ]);
    }
}
