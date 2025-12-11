<?php

namespace App\Controller;

use App\Repository\SponsorPartenaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class StatsController extends AbstractController
{
    #[Route('/favoris', name: 'admin_stats', methods: ['GET'])]
    public function favorites(SponsorPartenaireRepository $sponsorPartenaireRepository): Response
    {
        $favorites = $sponsorPartenaireRepository->findFavorites();

        return $this->render('admin/favoris/index.html.twig', [
            'favorites' => $favorites,
        ]);
    }
}
