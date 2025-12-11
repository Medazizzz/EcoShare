<?php

namespace App\Controller;

use App\Repository\SponsorPartenaireRepository;
use App\Repository\PubliciteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin_dashboard')]
    public function index(
        SponsorPartenaireRepository $sponsorRepo,
        PubliciteRepository $pubRepo
    ): Response {
        $totalSponsors    = $sponsorRepo->count(['type' => 'sponsor']);
        $totalPartenaires = $sponsorRepo->count(['type' => 'partenaire']);
        $totalPublicites  = $pubRepo->count([]);

        return $this->render('admin/dashboard.html.twig', [
            'totalSponsors'    => $totalSponsors,
            'totalPartenaires' => $totalPartenaires,
            'totalPublicites'  => $totalPublicites,
        ]);
    }
}
