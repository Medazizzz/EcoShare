    # EcoShare (Symfony 6) - Skeleton

This is a minimal Symfony 6 skeleton created for you. It includes two modern Twig templates:

- `templates/home.html.twig` — a modern landing/homepage template (responsive hero + features)
- `templates/dashboard.html.twig` — a simple admin/dashboard layout (cards + sidebar)

**What I generated:**
- Basic directory structure
- Minimal `public/index.php` front controller
- `src/Controller/HomeController.php` with two routes: `/` and `/dashboard`
- Tailwind-like simple CSS in `public/css/style.css` (no build step required)

**How to use locally**
1. Place this project where you want and run `composer install` (make sure PHP >= 8.1 and Composer are installed):

```bash
cd EcoShare-symfony6
composer install
```

2. Run Symfony local server (or PHP server):

```bash
# using Symfony CLI if installed
symfony server:start --dir=public
# or using PHP built-in server
php -S 127.0.0.1:8000 -t public
```

3. Open `http://127.0.0.1:8000/` for the landing page and `http://127.0.0.1:8000/dashboard` for the dashboard.

**Notes:**
- This is a frontend-focused skeleton. To integrate with your existing `BackToGreen` project backend, copy controllers/routes/templates while keeping your services and entities.
- I kept filenames and structure compatible with a standard Symfony app so you can drop these templates into an existing project.

If you want, I can also adapt the templates to specific colors, logos, or add more pages (login, profile, etc.).
