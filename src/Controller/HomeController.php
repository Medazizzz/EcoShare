<?php
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
    }
}
