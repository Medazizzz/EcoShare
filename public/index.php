<?php
<<<<<<< HEAD

use App\Kernel;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
=======
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
>>>>>>> 5596efc5a61a34dda8dc95036c6f56b1b0cfd685
