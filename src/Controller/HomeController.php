<?php
<<<<<<< HEAD

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
=======
// src/Controller/HomeController.php
namespace App\\Controller;

use Symfony\\Bundle\\FrameworkBundle\\Controller\\AbstractController;
use Symfony\\Component\\HttpFoundation\\Response;
use Symfony\\Component\\Routing\\Annotation\\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(): Response
    {
        // in a full Symfony app you would return \$this->render('home.html.twig');
        return new Response(file_get_contents(__DIR__.'/../../templates/home.html.twig.php'));
    }

    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function dashboard(): Response
    {
        return new Response(file_get_contents(__DIR__.'/../../templates/dashboard.html.twig.php'));
>>>>>>> 5596efc5a61a34dda8dc95036c6f56b1b0cfd685
    }
}
