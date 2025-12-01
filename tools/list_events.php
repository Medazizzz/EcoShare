<?php
$kernel = null;
// Simple script to list Evenement records (id, titre, image)
require __DIR__ . '/../vendor/autoload.php';

use App\Kernel;
use App\Entity\Evenement;

$kernel = new Kernel('dev', true);
$kernel->boot();
$container = $kernel->getContainer();
$doctrine = $container->get('doctrine');
$em = $doctrine->getManager();

$repo = $em->getRepository(Evenement::class);
$events = $repo->findAll();

if (!$events) {
    echo "No events found\n";
    exit(0);
}

foreach ($events as $e) {
    $id = $e->getId();
    $titre = $e->getTitre();
    $img = $e->getImage();
    printf("%d | %s | %s\n", $id, $titre, $img ?? '(null)');
}

$kernel->shutdown();
