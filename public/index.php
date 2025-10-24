<?php
// public/index.php - minimal front controller for local testing
use Symfony\Component\HttpFoundation\Request;

require __DIR__.'/../vendor/autoload.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Very small router just for this skeleton (for local preview without full Symfony stack)
if ($uri === '/' || $uri === '') {
    require __DIR__.'/../templates/home.html.twig.php';
    exit;
}
if ($uri === '/dashboard') {
    require __DIR__.'/../templates/dashboard.html.twig.php';
    exit;
}

http_response_code(404);
echo "404 - Not Found";
