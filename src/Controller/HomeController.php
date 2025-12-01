<?php

namespace App\Controller;

use App\Repository\EvenementRepository;
use App\Repository\CommentaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function roleChoice(): Response
    {
        return $this->render('role_choice.html.twig');
    }

    #[Route('/dashboard', name: 'dashboard')]
    public function dashboard(EvenementRepository $evenementRepository, CommentaireRepository $commentaireRepository): Response
    {
        $evenements = $evenementRepository->findAll();
        $totalEvents = count($evenements);
        $totalComments = count($commentaireRepository->findAll());

        $eventsWithCounts = [];
        foreach ($evenements as $event) {
            $eventsWithCounts[] = [
                'event' => $event,
                'comments' => $event->getCommentaires()->count(),
            ];
        }

        return $this->render('admin/dashboard.html.twig', [
            'totalEvents' => $totalEvents,
            'totalComments' => $totalComments,
            'eventsWithCounts' => $eventsWithCounts,
        ]);
    }

    #[Route('/user', name: 'user_home')]
    public function userHome(EvenementRepository $evenementRepository): Response
    {
        $evenements = $evenementRepository->findAll();

        return $this->render('user/home.html.twig', [
            'evenements' => $evenements,
        ]);
    }
}
