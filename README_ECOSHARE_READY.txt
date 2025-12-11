EcoShare — full Symfony project (without vendor) with:

- Freelancer front integrated under public/front and templates/user/*
- Gentelella admin integrated under public/admin and templates/admin/*
- Routes:
    * "/"      -> HomeController::index() -> templates/home.html.twig -> user/home.html.twig
    * "/admin" -> AdminController::index() -> templates/admin/dashboard.html.twig
- Root assets/ directory (for Symfony asset system / Encore)
- No security.yaml files (no login required)
- DATABASE_URL in .env uses database name "database"

Usage:

composer install
php bin/console cache:clear
symfony serve
